<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UpdateGlobalUser
{
    /**
     * Update a user, optionally assigning to multiple companies or as a global admin.
     *
     * @param  array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     password?: string,
     *     phone: ?string,
     *     title: ?string,
     *     is_global_user: bool,
     *     roles: array<int>,
     *     company_assignments: array<int, array{roles: array<int>, title: string}>,
     * }  $data
     */
    public function execute(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'title' => $data['is_global_user'] ? ($data['title'] ?? null) : null,
            ]);

            if (! empty($data['password'])) {
                $user->update(['password' => bcrypt($data['password'])]);
            }

            // Sync companies and roles
            if ($data['is_global_user']) {
                $user->companies()->detach();
                $this->assignGlobalRoles($user, $data['roles']);
            } else {
                // Ensure global roles are removed if switching to company user
                setPermissionsTeamId(null);
                $user->unsetRelation('roles')->unsetRelation('permissions');
                
                $globalRoles = Role::whereNull('company_id')->get();
                $user->roles()->detach($globalRoles);

                $this->assignCompanyRoles($user, $data['company_assignments']);
            }

            return $user;
        });
    }

    /**
     * Assign global roles (company_id IS NULL) to the user.
     *
     * @param  array<int>  $roleIds
     */
    private function assignGlobalRoles(User $user, array $roleIds): void
    {
        $roles = Role::whereIn('id', $roleIds)
            ->whereNull('company_id')
            ->get();

        if ($roles->isEmpty()) {
            throw new \Exception('The selected roles are not valid global roles.');
        }

        setPermissionsTeamId(null);
        $user->unsetRelation('roles')->unsetRelation('permissions');
        $user->syncRoles($roles);
    }

    /**
     * Attach companies with per-company title and roles.
     *
     * @param  array<int, array{roles: array<int>, title: string}>  $companyAssignments
     */
    private function assignCompanyRoles(User $user, array $companyAssignments): void
    {
        $syncData = [];
        foreach ($companyAssignments as $companyId => $assignment) {
            $syncData[$companyId] = ['title' => $assignment['title'] ?? null];
        }

        $existingCompanyIds = $user->companies()->pluck('companies.id')->toArray();
        $user->companies()->sync($syncData);

        // Remove roles for companies the user is no longer assigned to
        $removedCompanyIds = array_diff($existingCompanyIds, array_keys($companyAssignments));
        foreach ($removedCompanyIds as $removedId) {
            setPermissionsTeamId($removedId);
            $user->unsetRelation('roles')->unsetRelation('permissions');
            $user->syncRoles([]);
        }

        // Sync roles for currently assigned companies
        foreach ($companyAssignments as $companyId => $assignment) {
            setPermissionsTeamId($companyId);
            $user->unsetRelation('roles')->unsetRelation('permissions');
            
            $roleIds = $assignment['roles'] ?? [];
            if (! empty($roleIds)) {
                $roles = Role::whereIn('id', $roleIds)->where('company_id', $companyId)->get();
                $user->syncRoles($roles);
            } else {
                $user->syncRoles([]);
            }
        }
    }
}

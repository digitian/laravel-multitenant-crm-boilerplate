<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateGlobalUser
{
    /**
     * Create a user, optionally assigning to multiple companies or as a global admin.
     *
     * @param  array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     password: string,
     *     phone: ?string,
     *     title: ?string,
     *     is_global_user: bool,
     *     roles: array<int>,
     *     company_assignments: array<int, array{roles: array<int>, title: string}>,
     * }  $data
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'phone' => $data['phone'] ?? null,
                'title' => $data['is_global_user'] ? ($data['title'] ?? null) : null,
            ]);

            if ($data['is_global_user']) {
                $this->assignGlobalRoles($user, $data['roles']);
            } else {
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
        foreach ($companyAssignments as $companyId => $assignment) {
            // Attach user to company with title on pivot
            $user->companies()->attach($companyId, [
                'title' => $assignment['title'] ?? null,
            ]);

            // Assign company-scoped roles
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

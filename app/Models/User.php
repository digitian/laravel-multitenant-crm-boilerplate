<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'country',
        'zip_code',
        'title',
        'linkedin_url',
        'facebook_url',
        'x_url',
        'instagram_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user', 'user_id', 'company_id')
            ->withPivot('title');
    }

    /**
     * Get the roles assigned to the user for a specific company.
     *
     * @param  int|string  $companyId
     * @return Collection
     */
    public function getRolesForCompany($companyId)
    {
        $previousTeamId = getPermissionsTeamId();
        setPermissionsTeamId($companyId);
        $this->unsetRelation('roles');
        $roles = $this->roles;
        setPermissionsTeamId($previousTeamId);

        return $roles;
    }

    /**
     * Get the active role display name for the user.
     *
     * @return string|null
     */
    public function activeRoleName()
    {
        $companyId = session('active_company_id');

        if ($companyId) {
            $roles = $this->getRolesForCompany($companyId);
            if ($roles->isNotEmpty()) {
                $role = $roles->first();

                return $role->display_name ?? $role->name;
            }
        }

        $previousTeamId = getPermissionsTeamId();
        setPermissionsTeamId(null);
        $this->unsetRelation('roles');

        $role = $this->roles->first();

        setPermissionsTeamId($previousTeamId);
        $this->unsetRelation('roles');

        return $role ? ($role->display_name ?? $role->name) : null;
    }
}

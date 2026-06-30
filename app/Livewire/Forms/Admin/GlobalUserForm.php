<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class GlobalUserForm extends Form
{
    public ?User $user = null;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $phone = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $is_global_user = false;

    /** @var array<int> Selected company IDs */
    public array $companies = [];

    /**
     * Per-company assignments: [company_id => ['roles' => [...], 'title' => '...']]
     *
     * @var array<int, array{roles: array<int>, title: string}>
     */
    public array $company_assignments = [];

    /** @var array<int> Global user roles (only used when is_global_user is true) */
    public array $roles = [];

    /** Global user title (only used when is_global_user is true) */
    public string $title = '';

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';

        $isGlobal = $user->roles()->whereNull('roles.company_id')->exists();
        $this->is_global_user = $isGlobal;

        if ($isGlobal) {
            $this->title = $user->title ?? '';
            $this->roles = $user->roles()->whereNull('roles.company_id')->pluck('roles.id')->toArray();
        } else {
            $this->companies = $user->companies()->pluck('companies.id')->toArray();
            $assignments = [];
            foreach ($user->companies as $company) {
                $roles = $user->roles()->where('roles.company_id', $company->id)->pluck('roles.id')->toArray();
                $assignments[$company->id] = [
                    'roles' => $roles,
                    'title' => $company->pivot->title ?? '',
                ];
            }
            $this->company_assignments = $assignments;
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->user) {
            $rules['password'] = ['nullable', 'string', 'min:8'];
            $rules['password_confirmation'] = ['nullable', 'string', 'min:8', 'same:password'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8'];
            $rules['password_confirmation'] = ['required', 'string', 'min:8', 'same:password'];
        }

        if ($this->is_global_user) {
            $rules['companies'] = ['nullable', 'array', 'size:0'];
            $rules['roles'] = ['required', 'array', 'min:1'];
            $rules['roles.*'] = ['exists:roles,id'];
        } else {
            $rules['companies'] = ['required', 'array', 'min:1'];
            $rules['companies.*'] = ['exists:companies,id'];
            $rules['company_assignments'] = ['required', 'array', 'min:1'];
            $rules['company_assignments.*.roles'] = ['required', 'array', 'min:1'];
            $rules['company_assignments.*.roles.*'] = ['exists:roles,id'];
            $rules['company_assignments.*.title'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'companies.required' => 'Please select at least one company.',
            'companies.size' => 'Global users cannot be assigned to companies.',
            'roles.required' => 'Please select at least one role.',
            'company_assignments.required' => 'Please configure roles for each company.',
            'company_assignments.*.roles.required' => 'Please select at least one role for each company.',
        ];
    }
}

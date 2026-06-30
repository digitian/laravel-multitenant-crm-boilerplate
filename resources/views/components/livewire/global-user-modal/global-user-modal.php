<?php

use App\Actions\CreateGlobalUser;
use App\Actions\UpdateGlobalUser;
use App\Livewire\Forms\Admin\GlobalUserForm;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public GlobalUserForm $form;

    public Collection $companies;

    /** @var array<int, Collection> Roles grouped by company ID */
    public array $companyRolesMap = [];

    /** @var Collection Global roles (company_id IS NULL) */
    public Collection $globalRoles;

    public function mount(): void
    {
        $this->companies = Company::select('id', 'name')->orderBy('name')->get();
        $this->globalRoles = collect();
    }

    #[On('edit-global-user')]
    public function editUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->form->setUser($user);

        if ($this->form->is_global_user) {
            $this->loadGlobalRoles();
        } else {
            $selectedIds = array_map('intval', $this->form->companies);
            $this->loadCompanyRoles($selectedIds);
        }

        $this->dispatch('open-global-user-modal');
    }

    #[On('create-global-user')]
    public function createUserModal(): void
    {
        $this->resetForm();
        $this->dispatch('open-global-user-modal');
    }

    /**
     * When the company selection changes, sync company_assignments and reload roles.
     */
    public function updatedFormCompanies(): void
    {
        $selectedIds = array_map('intval', $this->form->companies);

        // Remove assignments for deselected companies
        $this->form->company_assignments = array_filter(
            $this->form->company_assignments,
            fn ($key) => in_array((int) $key, $selectedIds),
            ARRAY_FILTER_USE_KEY
        );

        // Add empty assignments for newly selected companies
        foreach ($selectedIds as $companyId) {
            if (! isset($this->form->company_assignments[$companyId])) {
                $this->form->company_assignments[$companyId] = [
                    'roles' => [],
                    'title' => '',
                ];
            }
        }

        $this->loadCompanyRoles($selectedIds);
    }

    /**
     * When the global user checkbox changes, clear everything and reload.
     */
    public function updatedFormIsGlobalUser(): void
    {
        $this->form->companies = [];
        $this->form->company_assignments = [];
        $this->form->roles = [];
        $this->form->title = '';
        $this->companyRolesMap = [];

        if ($this->form->is_global_user) {
            $this->loadGlobalRoles();
        }

        $this->dispatch('companies-reset');
    }

    /**
     * Load roles for each selected company.
     *
     * @param  array<int>  $companyIds
     */
    private function loadCompanyRoles(array $companyIds): void
    {
        $this->companyRolesMap = [];

        if (empty($companyIds)) {
            return;
        }

        $allRoles = Role::whereIn('company_id', $companyIds)
            ->select('id', 'name', 'display_name', 'company_id')
            ->get();

        foreach ($companyIds as $companyId) {
            $this->companyRolesMap[$companyId] = $allRoles
                ->where('company_id', $companyId)
                ->map(fn ($role) => [
                    'id' => $role->id,
                    'name' => $role->display_name ?? ucfirst($role->name),
                ])
                ->values()
                ->toArray();
        }
    }

    /**
     * Load global roles (company_id IS NULL).
     */
    private function loadGlobalRoles(): void
    {
        $this->globalRoles = Role::whereNull('company_id')
            ->select('id', 'name', 'display_name')
            ->get()
            ->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->display_name ?? ucfirst($role->name),
            ]);
    }

    public function save(CreateGlobalUser $createAction, UpdateGlobalUser $updateAction): mixed
    {
        $this->form->validate();

        $data = [
            'first_name' => $this->form->first_name,
            'last_name' => $this->form->last_name,
            'email' => $this->form->email,
            'password' => $this->form->password,
            'phone' => $this->form->phone,
            'title' => $this->form->title,
            'is_global_user' => $this->form->is_global_user,
            'roles' => $this->form->roles,
            'company_assignments' => $this->form->company_assignments,
        ];

        if ($this->form->user) {
            $user = $updateAction->execute($this->form->user, $data);
            flash()->success('User <b>'.$user->first_name.'</b> updated successfully');
        } else {
            $user = $createAction->execute($data);
            flash()->success('User <b>'.$user->first_name.'</b> created successfully');
        }

        return $this->js("setTimeout(() => { window.location.href = '".route('admin.users.index')."'; }, 1000);");
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->resetValidation();
        $this->companyRolesMap = [];
        $this->globalRoles = collect();
        $this->dispatch('companies-reset');
    }

    /**
     * Get company name by ID (helper for blade).
     */
    public function getCompanyName(int $companyId): string
    {
        return $this->companies->firstWhere('id', $companyId)?->name ?? 'Unknown';
    }
};

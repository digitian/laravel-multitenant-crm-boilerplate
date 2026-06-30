<?php

namespace Tests\Feature;

use App\Actions\CreateGlobalUser;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GlobalUserModalTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $this->admin->assignRole($adminRole);
    }

    public function test_global_user_action_creates_user_with_global_role(): void
    {
        $globalRole = Role::firstOrCreate(['name' => 'admin']);

        $action = new CreateGlobalUser;
        $user = $action->execute([
            'first_name' => 'Global',
            'last_name' => 'Tester',
            'email' => 'global@test.com',
            'password' => 'password123',
            'phone' => null,
            'title' => 'Global Title',
            'is_global_user' => true,
            'roles' => [$globalRole->id],
            'company_assignments' => [],
        ]);

        $this->assertModelExists($user);
        $this->assertEquals('Global', $user->first_name);
        $this->assertEquals('Global Title', $user->title);
        $this->assertTrue($user->companies->isEmpty());
        $this->assertTrue($user->hasRole('admin'));
    }

    public function test_action_creates_user_assigned_to_multiple_companies(): void
    {
        $companyA = Company::create([
            'name' => 'Company A',
            'email' => 'a@test.com',
            'slug' => 'company-a',
        ]);

        $companyB = Company::create([
            'name' => 'Company B',
            'email' => 'b@test.com',
            'slug' => 'company-b',
        ]);

        $roleA = Role::create([
            'name' => 'company_admin',
            'display_name' => 'Company Admin',
            'company_id' => $companyA->id,
        ]);

        $roleB = Role::create([
            'name' => 'company_admin',
            'display_name' => 'Company Admin',
            'company_id' => $companyB->id,
        ]);

        $action = new CreateGlobalUser;
        $user = $action->execute([
            'first_name' => 'Multi',
            'last_name' => 'Company',
            'email' => 'multi@test.com',
            'password' => 'password123',
            'phone' => '555-0100',
            'title' => null,
            'is_global_user' => false,
            'roles' => [],
            'company_assignments' => [
                $companyA->id => [
                    'roles' => [$roleA->id],
                    'title' => 'Manager A',
                ],
                $companyB->id => [
                    'roles' => [$roleB->id],
                    'title' => 'Manager B',
                ],
            ],
        ]);

        $this->assertModelExists($user);
        $this->assertCount(2, $user->companies);
        $this->assertTrue($user->companies->contains($companyA));
        $this->assertTrue($user->companies->contains($companyB));

        $pivotA = $user->companies()->where('company_id', $companyA->id)->first()->pivot;
        $pivotB = $user->companies()->where('company_id', $companyB->id)->first()->pivot;

        $this->assertEquals('Manager A', $pivotA->title);
        $this->assertEquals('Manager B', $pivotB->title);
    }

    public function test_action_throws_exception_for_invalid_global_roles(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'slug' => 'test-company',
        ]);

        $companyRole = Role::create([
            'name' => 'company_admin',
            'company_id' => $company->id,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The selected roles are not valid global roles.');

        $action = new CreateGlobalUser;
        $action->execute([
            'first_name' => 'Bad',
            'last_name' => 'User',
            'email' => 'bad@test.com',
            'password' => 'password123',
            'phone' => null,
            'title' => null,
            'is_global_user' => true,
            'roles' => [$companyRole->id],
            'company_assignments' => [],
        ]);
    }

    public function test_livewire_component_renders_with_companies(): void
    {
        Company::create(['name' => 'Test Co', 'email' => 'test@co.com', 'slug' => 'test-co']);

        Livewire::actingAs($this->admin)
            ->test('livewire.global-user-modal')
            ->assertSee('Create New User')
            ->assertSee('Assign to Company')
            ->assertSee('Global User')
            ->assertSee('Test Co');
    }

    public function test_livewire_component_loads_roles_when_company_selected(): void
    {
        $company = Company::create(['name' => 'Acme', 'email' => 'acme@test.com', 'slug' => 'acme']);
        $role = Role::create(['name' => 'editor', 'display_name' => 'Editor', 'company_id' => $company->id]);

        Livewire::actingAs($this->admin)
            ->test('livewire.global-user-modal')
            ->set('form.companies', [$company->id])
            ->assertSet('companyRolesMap.'.$company->id.'.0.id', $role->id)
            ->assertSet('companyRolesMap.'.$company->id.'.0.name', 'Editor');
    }

    public function test_livewire_component_loads_global_roles_when_global_checked(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        Livewire::actingAs($this->admin)
            ->test('livewire.global-user-modal')
            ->set('form.is_global_user', true)
            ->assertDispatched('companies-reset')
            ->assertSet('globalRoles.0.name', 'Admin');
    }

    public function test_livewire_component_validates_company_required_for_non_global(): void
    {
        Livewire::actingAs($this->admin)
            ->test('livewire.global-user-modal')
            ->set('form.first_name', 'Test')
            ->set('form.last_name', 'User')
            ->set('form.email', 'validate@test.com')
            ->set('form.password', 'password123')
            ->set('form.password_confirmation', 'password123')
            ->set('form.is_global_user', false)
            ->call('save')
            ->assertHasErrors(['form.companies']);
    }

    public function test_livewire_component_creates_global_user_successfully(): void
    {
        $globalRole = Role::firstOrCreate(['name' => 'admin']);

        Livewire::actingAs($this->admin)
            ->test('livewire.global-user-modal')
            ->set('form.first_name', 'Jane')
            ->set('form.last_name', 'Doe')
            ->set('form.email', 'jane@test.com')
            ->set('form.password', 'password123')
            ->set('form.password_confirmation', 'password123')
            ->set('form.is_global_user', true)
            ->set('form.roles', [$globalRole->id])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', ['email' => 'jane@test.com']);
    }
}

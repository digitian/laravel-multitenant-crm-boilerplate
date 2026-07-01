<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_index_page_loads_for_authenticated_user(): void
    {
        $this->actingAs($this->user)
            ->get(route('customers.index'))
            ->assertOk()
            ->assertViewIs('pages.customers.index');
    }

    public function test_index_page_redirects_unauthenticated_user(): void
    {
        $this->get(route('customers.index'))
            ->assertRedirect(route('login'));
    }

    public function test_index_displays_customers(): void
    {
        $customer = Customer::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);

        $this->actingAs($this->user)
            ->get(route('customers.index'))
            ->assertOk()
            ->assertSee('John')
            ->assertSee('Doe');
    }

    public function test_index_search_filters_by_name(): void
    {
        Customer::factory()->create(['first_name' => 'Alice', 'last_name' => 'Smith']);
        Customer::factory()->create(['first_name' => 'Bob', 'last_name' => 'Jones']);

        $this->actingAs($this->user)
            ->get(route('customers.index', ['search' => 'Alice']))
            ->assertOk()
            ->assertSee('Alice')
            ->assertDontSee('Bob');
    }

    public function test_index_search_filters_by_email(): void
    {
        Customer::factory()->create(['email' => 'findme@example.com']);
        Customer::factory()->create(['email' => 'hidden@example.com']);

        $this->actingAs($this->user)
            ->get(route('customers.index', ['search' => 'findme']))
            ->assertOk()
            ->assertSee('findme@example.com')
            ->assertDontSee('hidden@example.com');
    }

    public function test_index_sorts_by_name_ascending(): void
    {
        Customer::factory()->create(['first_name' => 'Zara']);
        Customer::factory()->create(['first_name' => 'Anna']);

        $response = $this->actingAs($this->user)
            ->get(route('customers.index', ['sort_by' => 'first_name', 'order_by' => 'asc']));

        $response->assertOk();
        $customers = $response->viewData('customers');
        $this->assertEquals('Anna', $customers->first()->first_name);
    }

    public function test_show_page_loads_for_authenticated_user(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->user)
            ->get(route('customers.show', $customer))
            ->assertOk()
            ->assertViewIs('pages.customers.show')
            ->assertSee($customer->first_name);
    }

    public function test_show_page_displays_created_by_user(): void
    {
        $customer = Customer::factory()->create(['created_by' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('customers.show', $customer))
            ->assertOk()
            ->assertSee($this->user->first_name);
    }

    public function test_customer_creation_via_livewire_modal(): void
    {
        Livewire::actingAs($this->user)
            ->test('livewire.customer-modal')
            ->call('createCustomerModal')
            ->set('form.first_name', 'Jane')
            ->set('form.last_name', 'Doe')
            ->set('form.email', 'jane@example.com')
            ->set('form.phone', '1234567890')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('customers', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_customer_creation_sets_created_by(): void
    {
        Livewire::actingAs($this->user)
            ->test('livewire.customer-modal')
            ->call('createCustomerModal')
            ->set('form.first_name', 'Mark')
            ->set('form.last_name', 'Test')
            ->set('form.email', 'mark@example.com')
            ->call('save')
            ->assertHasNoErrors();

        $customer = Customer::where('email', 'mark@example.com')->first();
        $this->assertNotNull($customer);
        $this->assertEquals($this->user->id, $customer->created_by);
    }

    public function test_customer_update_via_livewire_modal(): void
    {
        $customer = Customer::factory()->create([
            'first_name' => 'Old',
            'last_name' => 'Name',
            'email' => 'old@example.com',
        ]);

        Livewire::actingAs($this->user)
            ->test('livewire.customer-modal')
            ->call('editCustomer', $customer->id)
            ->set('form.first_name', 'New')
            ->set('form.last_name', 'Updated')
            ->call('save')
            ->assertHasNoErrors();

        $customer->refresh();
        $this->assertEquals('New', $customer->first_name);
        $this->assertEquals('Updated', $customer->last_name);
    }

    public function test_customer_creation_validation_requires_name_and_email(): void
    {
        Livewire::actingAs($this->user)
            ->test('livewire.customer-modal')
            ->call('createCustomerModal')
            ->set('form.first_name', '')
            ->set('form.last_name', '')
            ->set('form.email', '')
            ->call('save')
            ->assertHasErrors(['form.first_name', 'form.last_name', 'form.email']);
    }

    public function test_customer_creation_validation_rejects_duplicate_email(): void
    {
        Customer::factory()->create(['email' => 'existing@example.com']);

        Livewire::actingAs($this->user)
            ->test('livewire.customer-modal')
            ->call('createCustomerModal')
            ->set('form.first_name', 'Dup')
            ->set('form.last_name', 'Test')
            ->set('form.email', 'existing@example.com')
            ->call('save')
            ->assertHasErrors(['form.email']);
    }

    public function test_customer_deletion_via_livewire_modal(): void
    {
        $customer = Customer::factory()->create();

        Livewire::actingAs($this->user)
            ->test('livewire.delete-customer-modal')
            ->call('confirmDelete', $customer->id)
            ->call('deleteCustomer');

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_customer_deletion_via_controller(): void
    {
        $customer = Customer::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}

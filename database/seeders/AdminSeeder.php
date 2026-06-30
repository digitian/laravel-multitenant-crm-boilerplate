<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+1 234532 5223',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);

        // Assign the admin role to the user
        $admin->assignRole($adminRole);
    }
}

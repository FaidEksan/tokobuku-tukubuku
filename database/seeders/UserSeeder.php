<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // mencari Role dengan kondisi kolom name dengan role admin
        $role = Role::where('name', 'admin')->first();

        if ($role) {
            $user->assignRole($role);
        } else {
            $this->command->error("Role 'admin' not found.");
        }

    }
}
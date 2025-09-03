<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_role = Role::updateOrCreate(['name' => 'Super-Admin', 'guard_name' => 'web']);
        Role::updateOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::updateOrCreate(['name' => 'User', 'guard_name' => 'web']);
        $super_admin = Employee::updateOrCreate([], [
            'nip' => '1234567890',
            'phone' => '1234567890',
            'name' => 'developer',
            'email' => 'developer@invix.id',
            'hire_date' => now(),
            'password' => Hash::make('password')
        ]);
        $super_admin->assignRole($super_admin_role);
    }
}

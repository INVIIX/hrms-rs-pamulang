<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Employee::create([
            'nip' => '1234567890',
            'phone' => '1234567890',
            'name' => 'developer',
            'email' => 'developer@invix.id',
            'hire_date' => now(),
            'password' => Hash::make('password')
        ]);
    }
}

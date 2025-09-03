<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Group::create(['name' => 'Company']);
        Group::create(['name' => 'Department 1', 'parent_id' => $company->id]);
        Group::create(['name' => 'Department 2', 'parent_id' => $company->id]);
    }
}

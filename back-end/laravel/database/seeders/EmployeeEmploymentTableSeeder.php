<?php

namespace Database\Seeders;

use Database\Factories\EmployeeEmploymentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeEmploymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 700; $i++) {
            DB::table('employees_employments')
                ->insert(EmployeeEmploymentFactory::staticDefinition());
        }
    }
}

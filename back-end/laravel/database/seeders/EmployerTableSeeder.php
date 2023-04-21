<?php

namespace Database\Seeders;

use App\Models\Employer;
use Illuminate\Database\Seeder;

class EmployerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employer::factory()->count(5)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Employment;
use Illuminate\Database\Seeder;

class EmploymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employment::factory()->count(300)->create();
    }
}

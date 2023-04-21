<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeEmploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'employer_id' => Employer::inRandomOrder()->first()->id
        ];
    }

    public static function staticDefinition() {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'employer_id' => Employer::inRandomOrder()->first()->id
        ];
    }
}

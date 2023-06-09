<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employment>
 */
class EmploymentFactory extends Factory
{

    private const MAX_DECIMAL_PLACES = 2;
    private const MIN_SALARY_VALUE = 1200.00;
    private const MAX_SALARY_VALUE = 50000.00;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'office' => fake()->jobTitle(),
            'description' => fake()->text(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'salary' => fake()->
                randomFloat($this::MAX_DECIMAL_PLACES, $this:: MIN_SALARY_VALUE, $this::MAX_SALARY_VALUE),
            'user_id' => User::inRandomOrder()->where('type', 'employer')->first()->id
        ];
    }
}

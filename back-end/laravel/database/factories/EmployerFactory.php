<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{

    private const GENERATE_WITH_MASK = false;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cnpj' => fake()->cnpj($this::GENERATE_WITH_MASK),
            'bussiness_name' => fake()->company(),
            'fantasy_name' => fake()->company(),
            'user_id' => User::factory()->definitionWithType('employer')->create()->id
        ];
    }

}

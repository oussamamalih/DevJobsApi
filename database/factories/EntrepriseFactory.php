<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Entreprise>
 */
class EntrepriseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'company']),
            'name' => fake()->company(),
            'sector' => fake()->randomElement([
                'IT', 'Finance', 'Santé', 'Education', 'E-commerce',
                'Industrie', 'Télécommunications', 'Marketing',
            ]),
            'description' => fake()->paragraph(3),
            'logo' => null,
        ];
    }
}

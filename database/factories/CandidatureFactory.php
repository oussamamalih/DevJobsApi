<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Candidature>
 */
class CandidatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'candidate']),
            'offre_id' => Offre::factory(),
            'status' => fake()->randomElement(['pending', 'accepted', 'refused']),
        ];
    }
}

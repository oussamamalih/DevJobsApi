<?php

namespace Database\Factories;

use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'entreprise_id' => Entreprise::factory(),
            'title' => fake()->randomElement([
                'Développeur Laravel', 'Développeur Full Stack', 'Frontend Developer (React)',
                'Ingénieur DevOps', 'Data Analyst', 'Chef de projet IT',
                'Développeur Mobile Flutter', 'Administrateur Systèmes',
                'UI/UX Designer', 'Développeur Backend Node.js',
            ]),
            'description' => fake()->paragraphs(3, true),
            'contract_type' => fake()->randomElement(['CDI', 'CDD', 'Stage', 'Freelance']),
        ];
    }
}

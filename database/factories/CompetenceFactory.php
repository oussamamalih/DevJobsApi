<?php

namespace Database\Factories;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Competence>
 */
class CompetenceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js',
                'MySQL', 'PostgreSQL', 'MongoDB', 'Docker', 'Git', 'AWS',
                'TypeScript', 'Tailwind CSS', 'REST API', 'GraphQL',
                'Python', 'Django', 'Symfony', 'Redis',
            ]),
        ];
    }
}

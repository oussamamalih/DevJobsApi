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
                'Kubernetes', 'CI/CD', 'Angular', 'Next.js', 'Flutter',
                'Swift', 'Kotlin', 'Java', 'Spring Boot', '.NET',
                'C#', 'Ruby on Rails', 'Elasticsearch', 'RabbitMQ', 'Kafka',
                'Linux', 'Bash', 'Terraform', 'Azure', 'GCP',
            ]),
        ];
    }
}

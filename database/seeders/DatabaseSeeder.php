<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Competence;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Test / fixed accounts (easy to log in with in Postman) ---
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'DevJobs',
            'email' => 'admin@devjobs.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $demoCompanyUser = User::factory()->create([
            'first_name' => 'Sara',
            'last_name' => 'Alami',
            'email' => 'company@devjobs.test',
            'password' => bcrypt('password'),
            'role' => 'company',
        ]);

        User::factory()->create([
            'first_name' => 'Youssef',
            'last_name' => 'Benali',
            'email' => 'candidate@devjobs.test',
            'password' => bcrypt('password'),
            'role' => 'candidate',
        ]);

        // --- Skills pool (20 fixed skills) ---
        $competences = Competence::factory(20)->create();

        // --- One entreprise tied to the demo company account ---
        $demoEntreprise = Entreprise::factory()->create([
            'user_id' => $demoCompanyUser->id,
            'name' => 'TechCorp',
        ]);

        Offre::factory(3)
            ->create(['entreprise_id' => $demoEntreprise->id])
            ->each(function (Offre $offre) use ($competences) {
                $offre->competences()->attach(
                    $competences->random(rand(2, 5))->pluck('id')
                );
            });

        // --- 5 more random companies, each with 2-4 offers ---
        Entreprise::factory(5)
            ->create()
            ->each(function (Entreprise $entreprise) use ($competences) {
                Offre::factory(rand(2, 4))
                    ->create(['entreprise_id' => $entreprise->id])
                    ->each(function (Offre $offre) use ($competences) {
                        $offre->competences()->attach(
                            $competences->random(rand(2, 5))->pluck('id')
                        );
                    });
            });

        // --- 15 candidates applying to random offers ---
        $candidates = User::factory(15)->state(['role' => 'candidate'])->create();
        $offres = Offre::all();

        foreach ($candidates as $candidate) {
            // each candidate applies to 1-3 different offers
            $offres->random(rand(1, 3))->unique('id')->each(function (Offre $offre) use ($candidate) {
                Candidature::factory()->create([
                    'user_id' => $candidate->id,
                    'offre_id' => $offre->id,
                ]);
            });
        }
    }
}

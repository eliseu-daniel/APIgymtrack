<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StructureSeeder::class,          // muscle_groups, meals, workout_types
            AdministratorSeeder::class,
            EducatorSeeder::class,
            PatientSeeder::class,

            AnthropometrySeeder::class,      // depende de patients

            WorkoutSeeder::class,            // cria exercises + workouts
            WorkoutItemSeeder::class,        // depende de workouts + exercises
            WorkoutFeedbackSeeder::class,    // depende de workout_items

            FoodSeeder::class,               // depende de nada
            PatientRegistrationSeeder::class, // depende de patients + educators
            PatientWeightSeeder::class,      // depende de patients

            DietSeeder::class,               // depende de patients + meals + food
        ]);
    }
}

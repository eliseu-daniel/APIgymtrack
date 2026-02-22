<?php

namespace Database\Seeders;

use App\Models\Workout;
use App\Models\WorkoutItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workouts = Workout::all();

        foreach ($workouts as $workout) {
            WorkoutItem::factory()->count(5)->create([
                'workout_id' => $workout->id,
            ]);
        }
    }
}

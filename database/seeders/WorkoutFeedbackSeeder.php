<?php

namespace Database\Seeders;

use App\Models\WorkoutFeedback;
use App\Models\WorkoutItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $items = WorkoutItem::all();

        foreach ($items as $item) {
            WorkoutFeedback::factory()->count(1)->create([
                'workout_item_id' => $item->id,
            ]);
        }
    }
}

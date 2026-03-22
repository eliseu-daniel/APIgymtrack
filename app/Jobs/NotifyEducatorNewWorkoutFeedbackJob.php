<?php

namespace App\Jobs;

use App\Models\WorkoutFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyEducatorNewWorkoutFeedbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $workoutFeedbackId) {}

    public function handle(): void
    {
        $feedback = WorkoutFeedback::query()
            ->with(['workoutItem.workout.patient.registrations'])
            ->find($this->workoutFeedbackId);

        if (!$feedback) {
            return;
        }

        $educatorIds = $feedback->workoutItem?->workout?->patient?->registrations
            ?->pluck('educator_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray() ?? [];

        Log::info('Novo workout feedback criado', [
            'workout_feedback_id' => $feedback->id,
            'workout_item_id' => $feedback->workout_item_id,
            'patient_id' => $feedback->workoutItem?->workout?->patient?->id,
            'educator_ids' => $educatorIds,
            'created_at' => $feedback->created_at,
        ]);
    }
}

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
        // Sem persistência: o front detecta "novos" via created_at (endpoint).
        // Job fica como gancho p/ log / telemetria / broadcast futuro.
        $exists = WorkoutFeedback::query()
            ->where('id', $this->workoutFeedbackId)
            ->exists();

        if ($exists) {
            Log::info('Novo workout feedback criado', [
                'workout_feedback_id' => $this->workoutFeedbackId,
            ]);
        }
    }
}

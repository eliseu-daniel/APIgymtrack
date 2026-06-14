<?php

namespace App\Listeners;

use App\Events\WorkoutFeedbackSubmitted;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SendWorkoutFeedbackNotification
{
    public function handle(WorkoutFeedbackSubmitted $event): void
    {
        Log::info('Novo workout feedback criado', [
            'patient_id' => $event->patientId,
            'comment' => $event->comment,
        ]);

        try {
            Notification::create([
                'type' => 'feedback',
                'title' => 'Um novo feedback de treino',
                'message' => $event->patientName . ' enviou um feedback de treino',
                'comment' => $event->comment,
                'patient_id' => $event->patientId,
                'educator_id' => $event->educatorId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para workout feedback', ['error' => $e->getMessage()]);
        }
    }
}

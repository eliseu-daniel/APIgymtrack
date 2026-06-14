<?php

namespace App\Listeners;

use App\Events\WorkoutItemConfirmed;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SendWorkoutItemNotification
{
    public function handle(WorkoutItemConfirmed $event): void
    {
        Log::info('Workout item liberado para paciente', [
            'workout_item_id' => $event->workoutItemId,
            'patient_id' => $event->patientId,
        ]);

        try {
            Notification::create([
                'type' => 'workout',
                'title' => 'Nova atualização no treino',
                'message' => 'Um item do seu treino foi liberado.',
                'comment' => null,
                'patient_id' => $event->patientId,
                'educator_id' => $event->educatorId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para workout item', ['error' => $e->getMessage()]);
        }
    }
}

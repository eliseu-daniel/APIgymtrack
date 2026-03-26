<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotifyPatientWorkoutItemConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $workoutItemId,
        public int $patientId,
    ) {}

    public function handle(): void
    {
        Log::info('Workout item liberado para paciente', [
            'workout_item_id' => $this->workoutItemId,
            'patient_id' => $this->patientId,
        ]);

        try {
            Notification::create([
                'type' => 'workout',
                'title' => 'Nova atualização no treino',
                'message' => 'Um item do seu treino foi liberado.',
                'comment' => null,
                'patient_id' => $this->patientId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para workout item', ['error' => $e->getMessage()]);
        }
    }
}

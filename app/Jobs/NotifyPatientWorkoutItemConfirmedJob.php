<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyPatientWorkoutItemConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $workoutItemId,
        public int $patientId,
    ) {}

    public function handle(): void
    {
        // Sem tabela/redis: a "notificação" é o próprio send_notification = 1 no workout_items.
        // Job fica como gancho (log/telemetria/broadcast futuro).
        Log::info('Workout item liberado para paciente', [
            'workout_item_id' => $this->workoutItemId,
            'patient_id' => $this->patientId,
        ]);
    }
}

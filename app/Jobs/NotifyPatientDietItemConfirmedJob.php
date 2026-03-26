<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotifyPatientDietItemConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $dietItemId,
        public int $patientId,
        public int $educatorId
    ) {}

    public function handle(): void
    {
        Log::info('Diet item liberado para paciente', [
            'diet_item_id' => $this->dietItemId,
            'patient_id' => $this->patientId,
        ]);

        try {
            Notification::create([
                'type' => 'diet',
                'title' => 'Nova atualização na dieta',
                'message' => 'Um item da sua dieta foi liberado.',
                'comment' => null,
                'patient_id' => $this->patientId,
                'educator_id' => $this->educatorId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para diet item', ['error' => $e->getMessage()]);
        }
    }
}

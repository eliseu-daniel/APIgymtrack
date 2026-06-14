<?php

namespace App\Listeners;

use App\Events\DietItemConfirmed;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SendDietItemNotification
{
    public function handle(DietItemConfirmed $event): void
    {
        Log::info('Diet item liberado para paciente', [
            'diet_item_id' => $event->dietItemId,
            'patient_id' => $event->patientId,
        ]);

        try {
            Notification::create([
                'type' => 'diet',
                'title' => 'Nova atualização na dieta',
                'message' => 'Um item da sua dieta foi liberado.',
                'comment' => null,
                'patient_id' => $event->patientId,
                'educator_id' => $event->educatorId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para diet item', ['error' => $e->getMessage()]);
        }
    }
}

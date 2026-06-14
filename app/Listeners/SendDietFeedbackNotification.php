<?php

namespace App\Listeners;

use App\Events\DietFeedbackSubmitted;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class SendDietFeedbackNotification
{
    public function handle(DietFeedbackSubmitted $event): void
    {
        Log::info('Novo feedback da dieta pelo paciente', [
            'patient_id' => $event->patientId,
            'comment' => $event->comment,
        ]);

        try {
            Notification::create([
                'type' => 'feedback',
                'title' => 'Um novo feedback de dieta',
                'message' => $event->patientName . ' enviou um feedback de dieta',
                'comment' => $event->comment,
                'patient_id' => $event->patientId,
                'educator_id' => $event->educatorId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para diet feedback', ['error' => $e->getMessage()]);
        }
    }
}

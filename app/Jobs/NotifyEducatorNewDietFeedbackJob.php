<?php

namespace App\Jobs;

use App\Models\DietFeedback;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyEducatorNewDietFeedbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $patientId,
        public string $patientName,
        public string $comment

    ) {}

    public function handle(): void
    {
        Log::info('Novo feedback da dieta pelo paciente', [
            'patient_id' => $this->patientId,
            'comment' => $this->comment,
        ]);

        try {
            Notification::create([
                'type' => 'feedback',
                'title' => 'Um novo feedback de dieta',
                'message' => $this->patientName . ' enviou um feedback de dieta',
                'comment' => $this->comment,
                'patient_id' => $this->patientId,
                'read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar notification para diet feedback', ['error' => $e->getMessage()]);
        }
    }
}

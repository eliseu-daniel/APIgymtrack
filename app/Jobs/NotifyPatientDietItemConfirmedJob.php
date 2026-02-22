<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyPatientDietItemConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $dietItemId,
        public int $patientId,
    ) {}

    public function handle(): void
    {
        // Sem persistência extra, o "sinal" é o próprio diet_items.send_notification = 1
        Log::info('Diet item liberado para paciente', [
            'diet_item_id' => $this->dietItemId,
            'patient_id' => $this->patientId,
        ]);
    }
}

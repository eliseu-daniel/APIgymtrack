<?php

namespace App\Jobs;

use App\Models\DietFeedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyEducatorNewDietFeedbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $dietFeedbackId) {}

    public function handle(): void
    {
        // Como você NÃO quer tabela nova nem Redis,
        // a "notificação" pro front será derivada do created_at via endpoint.
        // Então o Job pode ficar como gancho (log/telemetria/integração futura).

        $exists = DietFeedback::query()
            ->where('id', $this->dietFeedbackId)
            ->exists();

        if ($exists) {
            Log::info('Novo diet feedback criado', [
                'diet_feedback_id' => $this->dietFeedbackId,
            ]);
        }
    }
}

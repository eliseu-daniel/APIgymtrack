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
        $feedback = DietFeedback::query()
            ->with(['diet.patient.registrations'])
            ->find($this->dietFeedbackId);

        if (!$feedback) {
            return;
        }

        $educatorIds = $feedback->diet?->patient?->registrations
            ?->pluck('educator_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray() ?? [];

        Log::info('Novo diet feedback criado', [
            'diet_feedback_id' => $feedback->id,
            'diet_id' => $feedback->diet_id,
            'patient_id' => $feedback->diet?->patient?->id,
            'educator_ids' => $educatorIds,
            'created_at' => $feedback->created_at,
        ]);
    }
}

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
            ->select(
                'diet_feedback.id',
                'diet_feedback.diet_id',
                'diet_feedback.created_at',
                'diets.patient_id'
            )
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->where('diet_feedback.id', $this->dietFeedbackId)
            ->first();

        if (!$feedback) {
            return;
        }

        $educatorIds = \App\Models\PatientRegistration::query()
            ->where('patient_id', $feedback->patient_id)
            ->pluck('educator_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        Log::info('Novo diet feedback criado', [
            'diet_feedback_id' => $feedback->id,
            'diet_id' => $feedback->diet_id,
            'patient_id' => $feedback->patient_id,
            'educator_ids' => $educatorIds,
            'created_at' => $feedback->created_at,
        ]);
    }
}

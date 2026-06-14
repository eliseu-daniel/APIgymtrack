<?php

namespace App\Services;

use App\Models\DietFeedback;
use App\Models\WorkoutFeedback;
use App\Models\Diet;
use App\Models\WorkoutItem;
use App\Jobs\NotifyEducatorNewDietFeedbackJob;
use App\Jobs\NotifyEducatorNewWorkoutFeedbackJob;
use Illuminate\Database\Eloquent\Collection;

class FeedbackService
{
    public function getDietFeedbacks(int $educatorId): Collection
    {
        return DietFeedback::query()
            ->select([
                'diet_feedback.*',
                'diet_feedback.id as diet_feedback_id',
                'patients.name as patient_name',
                'diets.id as diet_id',
            ])
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->orderBy('diet_feedback.created_at', 'desc')
            ->get();
    }

    public function getDietFeedback(int $educatorId, int $id): ?DietFeedback
    {
        return DietFeedback::query()
            ->select([
                'diet_feedback.*',
                'patients.name as patient_name',
            ])
            ->join('diets', 'diets.id', '=', 'diet_feedback.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('diet_feedback.id', $id)
            ->first();
    }

    public function createDietFeedback(array $data): DietFeedback
    {
        return DietFeedback::create([
            'diet_id' => $data['diet_id'],
            'comment' => $data['comment'],
            'send_notification' => $data['send_notification'] ?? 1,
        ]);
    }

    public function dispatchDietFeedbackNotification(DietFeedback $feedback, int $educatorId): void
    {
        $data = Diet::query()
            ->select([
                'diets.id as diet_id',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patient_registrations.educator_id as educator_id',
            ])
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('diets.id', $feedback->diet_id)
            ->first();

        if ($data && $data->educator_id) {
            NotifyEducatorNewDietFeedbackJob::dispatch(
                (int) $data->patient_id,
                (string) $data->patient_name,
                (string) $feedback->comment,
                (int) $data->educator_id
            );
        }
    }

    public function getWorkoutFeedbacks(int $educatorId): Collection
    {
        return WorkoutFeedback::query()
            ->select([
                'workout_feedback.id as workout_feedback_id',
                'workout_feedback.*',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'workouts.id as workout_id',
                'workout_items.id as workout_item_id',
            ])
            ->join('workout_items', 'workout_items.id', '=', 'workout_feedback.workout_item_id')
            ->join('workouts', 'workouts.id', '=', 'workout_items.workout_id')
            ->join('patients', 'patients.id', '=', 'workouts.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->orderBy('workout_feedback.created_at', 'desc')
            ->get();
    }

    public function getWorkoutFeedback(int $educatorId, int $id): ?WorkoutFeedback
    {
        return WorkoutFeedback::select(
            'workout_feedback.id as workout_feedback_id',
            'workout_feedback.*',
            'patients.id as patient_id',
            'patients.name as patient_name',
            'workouts.id as workout_id',
            'workout_items.id as workout_item_id',
        )
            ->join('workout_items', 'workout_items.id', '=', 'workout_feedback.workout_item_id')
            ->join('workouts', 'workouts.id', '=', 'workout_items.workout_id')
            ->join('patients', 'patients.id', '=', 'workouts.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('workout_feedback.id', $id)
            ->first();
    }

    public function createWorkoutFeedback(array $data): WorkoutFeedback
    {
        return WorkoutFeedback::create([
            'workout_item_id' => $data['workout_item_id'],
            'comment' => $data['comment'],
            'send_notification' => $data['send_notification'] ?? 1,
        ]);
    }

    public function dispatchWorkoutFeedbackNotification(WorkoutFeedback $feedback): void
    {
        $data = WorkoutItem::query()
            ->select([
                'workouts.id as workout_id',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patient_registrations.educator_id as educator_id',
            ])
            ->join('workouts', 'workouts.id', '=', 'workout_items.workout_id')
            ->join('patients', 'patients.id', '=', 'workouts.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('workout_items.id', $feedback->workout_item_id)
            ->first();

        if ($data && $data->educator_id) {
            NotifyEducatorNewWorkoutFeedbackJob::dispatch(
                (int) $data->patient_id,
                (string) $data->patient_name,
                (string) $feedback->comment,
                (int) $data->educator_id
            );
        }
    }
}

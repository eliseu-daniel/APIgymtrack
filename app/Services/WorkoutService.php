<?php

namespace App\Services;

use App\Models\Workout;
use App\Models\WorkoutItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkoutService
{
    public function getWorkoutsForEducator(int $educatorId, int $perPage = 15): LengthAwarePaginator
    {
        return Workout::select(
            'workouts.id as workout_id',
            'workouts.*',
            'patients.id as patient_id',
            'patients.name',
            'workout_types.id as workout_type_id',
            'workout_types.workout_type as workout_type_name'
        )
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('workout_types', 'workout_types.id', '=', 'workouts.workout_type_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->orderBy('workouts.start_date', 'desc')
            ->paginate($perPage);
    }

    public function getWorkoutForEducator(int $educatorId, int $workoutId): ?Workout
    {
        return Workout::select(
            'workouts.id as workout_id',
            'workouts.*',
            'patients.id as patient_id',
            'patients.name',
            'workout_types.id as workout_type_id',
            'workout_types.workout_type as workout_type_name'
        )
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('workout_types', 'workout_types.id', '=', 'workouts.workout_type_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('workouts.id', $workoutId)
            ->first();
    }

    public function createWorkout(array $data): Workout
    {
        return Workout::create($data);
    }

    public function updateWorkout(int $id, array $data): bool
    {
        return (bool) Workout::where('id', $id)->update($data);
    }

    public function deleteWorkout(int $id): ?bool
    {
        $workout = Workout::find($id);
        if (!$workout) {
            return null;
        }
        return $workout->delete();
    }

    public function getWorkoutsForPatient(int $patientId): Collection
    {
        return Workout::select(
            'workouts.*',
            'patients.id as patient_id',
            'patients.name',
            'workout_types.id as workout_type_id',
            'workout_types.workout_type as workout_type_name'
        )
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('workout_types', 'workout_types.id', '=', 'workouts.workout_type_id')
            ->where('workouts.patient_id', $patientId)
            ->orderBy('workouts.start_date', 'desc')
            ->get();
    }

    public function getWorkoutItems(int $educatorId, int $perPage = 15): LengthAwarePaginator
    {
        return WorkoutItem::select(
            'workout_items.id as workout_item_id',
            'workout_items.*',
            'exercises.exercise as exercise_name'
        )
            ->join('exercises', 'workout_items.exercise_id', '=', 'exercises.id')
            ->join('workouts', 'workout_items.workout_id', '=', 'workouts.id')
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('workout_items.is_active', true)
            ->paginate($perPage);
    }
}

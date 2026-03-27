<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutFeedbackRequest;
use App\Jobs\NotifyEducatorNewWorkoutFeedbackJob;
use App\Models\WorkoutFeedback;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorkoutFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;

        $data = WorkoutFeedback::query()
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
            ->where('patient_registrations.educator_id', $idEducator)
            ->orderBy('workout_feedback.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'DataFeedback' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWorkoutFeedbackRequest $request): JsonResponse
    {
        $workoutFeedbackValidated = $request->validated();
        $idEducator = request()->user()->id;

        $workoutFeedback = WorkoutFeedback::create([
            'workout_item_id' => $workoutFeedbackValidated['workout_item_id'],
            'comment' => $workoutFeedbackValidated['comment'],
            'send_notification' => $workoutFeedbackValidated['send_notification'] ?? 1,
        ]);



        if ($workoutFeedback && $workoutFeedback->send_notification) {
            $data = WorkoutFeedback::query()
                ->select([
                    'workouts.id as workout_id',
                    'patients.id as patient_id',
                    'patients.name as patient_name',
                ])
                ->join('workouts', 'workouts.id', '=', 'workout_feedback.diet_id')
                ->join('patients', 'patients.id', '=', 'workouts.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('workouts.id', $workoutFeedback->diet_id)
                ->where('patient_registrations.educator_id', $idEducator)
                ->first();

            if ($data) {
                NotifyEducatorNewWorkoutFeedbackJob::dispatch(
                    (int) $data->patient_id,
                    (string) $data->patient_name,
                    (string) $workoutFeedback->comment,
                    (int) $data->educator_id
                );
            }
        }


        return response()->json([
            'status' => true,
            'message' => 'Feedback do treino criado com sucesso',
            'DataFeedback' => $workoutFeedback
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $workoutFeedback = WorkoutFeedback::select(
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
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('workout_feedback.id', $id)
            ->first();

        if (!$workoutFeedback) {
            return response()->json(['status' => false, 'message' => 'Feeback não encontrado'], 404);
        }
        return response()->json(['status' => true, 'message' => $workoutFeedback], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateWorkoutFeedbackRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function newForEducator(Request $request): JsonResponse
    {
        $idEducator = $request->user()->id;
        $after = $request->query('after');

        $query = \App\Models\Notification::query()
            ->where('educator_id', $idEducator)
            ->where('type', 'workout_feedback')
            ->where('read', false)
            ->orderBy('created_at', 'desc');

        if ($after) {
            $query->where('created_at', '>', $after);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de feedback de treino encontrada.'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}

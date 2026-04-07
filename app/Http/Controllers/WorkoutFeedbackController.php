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

        $data = WorkoutFeedback::with('workoutItem.workout.patient')
            ->whereHas('workoutItem.workout.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($feedback) {
                $feedbackArray = $feedback->toArray();
                $feedbackArray['workout_feedback_id'] = $feedback->id;
                $feedbackArray['patient_id'] = $feedback->workoutItem->workout->patient_id ?? null;
                $feedbackArray['patient_name'] = $feedback->workoutItem->workout->patient['name'] ?? null;
                $feedbackArray['workout_id'] = $feedback->workoutItem->workout_id ?? null;
                $feedbackArray['workout_item_id'] = $feedback->workout_item_id;
                unset($feedbackArray['workout_item']);
                return $feedbackArray;
            });

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
            $itemWithPatient = \App\Models\WorkoutItem::with('workout.patient.registrations')->find($workoutFeedback->workout_item_id);

            if ($itemWithPatient && $itemWithPatient->workout && $itemWithPatient->workout->patient) {
                $registration = $itemWithPatient->workout->patient->registrations->first();
                
                if ($registration && $registration->educator_id) {
                    NotifyEducatorNewWorkoutFeedbackJob::dispatch(
                        (int) $itemWithPatient->workout->patient_id,
                        (string) $itemWithPatient->workout->patient->name,
                        (string) $workoutFeedback->comment,
                        (int) $registration->educator_id
                    );
                }
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
        $workoutFeedback = WorkoutFeedback::with('workoutItem.workout.patient')
            ->whereHas('workoutItem.workout.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->first();

        if (!$workoutFeedback) {
            return response()->json(['status' => false, 'message' => 'Feeback não encontrado'], 404);
        }
        
        $feedbackArray = $workoutFeedback->toArray();
        $feedbackArray['workout_feedback_id'] = $workoutFeedback->id;
        $feedbackArray['patient_id'] = $workoutFeedback->workoutItem->workout->patient_id ?? null;
        $feedbackArray['patient_name'] = $workoutFeedback->workoutItem->workout->patient['name'] ?? null;
        $feedbackArray['workout_id'] = $workoutFeedback->workoutItem->workout_id ?? null;
        $feedbackArray['workout_item_id'] = $workoutFeedback->workout_item_id;
        unset($feedbackArray['workout_item']);

        return response()->json(['status' => true, 'message' => $feedbackArray], 200);
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
            ->where('type', 'feedback')
            ->where('read', false)
            ->orderBy('created_at', 'desc');

        if ($after) {
            $query->where('created_at', '>', $after);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de feedback de treino encontrada.'], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}

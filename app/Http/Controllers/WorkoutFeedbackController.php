<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutFeedbackRequest;
use App\Models\WorkoutFeedback;
use Illuminate\Http\Request;

class WorkoutFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'DataFeedback' => WorkoutFeedback::select(
            'workout_feedbacks.*',
            'patients.name'
        )
            ->join('patients', 'workout_feedbacks.patient_id', '=', 'patients.id')
            ->join('workouts', 'workout_feedbacks.workout_id', '=', 'workouts.id')
            ->where('patients.educator_id', request()->user()->id)
            ->get()], 200);
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
    public function store(CreateWorkoutFeedbackRequest $request)
    {
        $workoutFeedbackValited = $request->validated();
        $workoutFeedback = WorkoutFeedback::create($workoutFeedbackValited);
        return response()->json(['status' => true, 'message:' => 'Feedback do treino criado com sucesso', 'DataFeedback' => $workoutFeedback], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // essa poha deve ta errada mas depois eu vejo
        $idEducator = request()->user()->id;
        $workoutFeedback = WorkoutFeedback::select('workout_feedbacks.*', 'patients.name', 'workouts.name as workout_name')
            ->join('patients', 'workout_feedbacks.patient_id', '=', 'patients.id')
            ->join('workouts', 'workout_feedbacks.workout_id', '=', 'workouts.id')
            ->where('patients_registration.educator_id', $idEducator)
            ->where('workout_feedbacks.id', $id)
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
}

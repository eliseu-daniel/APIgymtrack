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
        return response()->json(['status' => true, 'DataFeedback' => WorkoutFeedback::all()], 200);
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
        $workoutFeedback = WorkoutFeedback::find($id);
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

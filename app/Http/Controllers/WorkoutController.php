<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutRequest;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'WorkoutData' => Workout::all()], 200);
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
    public function store(CreateWorkoutRequest $request)
    {
        $workoutValidated = $request->validated();
        $workout = Workout::create($workoutValidated);
        return response()->json(['status' => true, 'message:' => 'Treino criado com sucesso', 'workout' => $workout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workout = Workout::find($id);
        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        return response()->json(['status' => true, 'workout' => $workout], 200);
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
    public function update(CreateWorkoutRequest $request, string $id)
    {
        $workout = Workout::find($id);
        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        $workoutValidated = $request->validated();
        $workout  = Workout::where('id', $id)->update($workoutValidated);
        return response()->json(['status' => true, 'message' => 'Treino atualizado com sucesso', 'workout' => $workout], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workout = Workout::find($id);
        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        $workout->delete();
        return response()->json(['status' => true, 'message' => 'Treino deletado com sucesso'], 200);
    }
}

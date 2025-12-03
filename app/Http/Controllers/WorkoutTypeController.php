<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutTypeRequest;
use App\Models\WorkoutType;
use Illuminate\Http\Request;

class WorkoutTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'WorkoutTypeData' => WorkoutType::all()], 200);
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
    public function store(CreateWorkoutTypeRequest $request)
    {
        $workoutType = request()->validated();
        $workoutTypeCreate = WorkoutType::created($workoutType);

        return response()->json(['status' => true, 'message' => 'Tipo de Treino criado com sucesso.', 'WorkoutTypeData' => $workoutTypeCreate], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workoutType = WorkoutType::find($id);
        if (!$workoutType) {
            return response()->json(['status' => false, 'message' => 'Tipo de treino não existe'], 404);
        }
        return response()->json(['status' => true, 'WorkoutTypeData' => $workoutType], 200);
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
    public function update(CreateWorkoutTypeRequest $request, string $id)
    {
        $workoutType = WorkoutType::find($id);
        if (!$workoutType) {
            return response()->json(['status' => false, 'message' => 'Tipo de treino não existe'], 404);
        }
        $workoutType->update(['is_active' => false]);
        $workoutTypeCreate = request()->validated();
        $workoutTypeCreate = WorkoutType::created($workoutTypeCreate);
        return response()->json(['status' => true, 'message' => 'Tipo de Treino atualizado com sucesso.', 'WorkoutTypeData' => $workoutTypeCreate], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workoutType = WorkoutType::find($id);
        $workoutType->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Tipo de Treino removido com sucesso.'], 200);
    }
}

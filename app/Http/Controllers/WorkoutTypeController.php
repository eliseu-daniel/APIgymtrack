<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutTypeRequest;
use App\Models\WorkoutType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WorkoutTypeController extends Controller
{
    public function index()
    {
        $workoutTypes = Cache::remember('workout_types:all', 86400, function () {
            return WorkoutType::all();
        });

        return response()->json(['status' => true, 'WorkoutTypeData' => $workoutTypes], 200);
    }

    public function create()
    {
        //
    }

    public function store(CreateWorkoutTypeRequest $request)
    {
        $workoutType = $request->validated();
        $workoutTypeCreate = WorkoutType::create($workoutType);
        Cache::forget('workout_types:all');
        return response()->json(['status' => true, 'message' => 'Tipo de Treino criado com sucesso.', 'WorkoutTypeData' => $workoutTypeCreate], 201);
    }

    public function show(string $id)
    {
        $workoutType = Cache::remember("workout_types:{$id}", 86400, function () use ($id) {
            return WorkoutType::find($id);
        });

        if (!$workoutType) {
            return response()->json(['status' => false, 'message' => 'Tipo de treino não existe'], 404);
        }
        return response()->json(['status' => true, 'WorkoutTypeData' => $workoutType], 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CreateWorkoutTypeRequest $request, string $id)
    {
        $workoutType = WorkoutType::find($id);
        if (!$workoutType) {
            return response()->json(['status' => false, 'message' => 'Tipo de treino não existe'], 404);
        }
        $workoutType->update(['is_active' => false]);
        $workoutTypeCreate = $request->validated();
        $workoutTypeCreate = WorkoutType::create($workoutTypeCreate);
        Cache::forget('workout_types:all');
        return response()->json(['status' => true, 'message' => 'Tipo de Treino atualizado com sucesso.', 'WorkoutTypeData' => $workoutTypeCreate], 200);
    }

    public function destroy(string $id)
    {
        $workoutType = WorkoutType::find($id);
        $workoutType->update(['is_active' => false]);
        Cache::forget('workout_types:all');
        Cache::forget("workout_types:{$id}");
        return response()->json(['status' => true, 'message' => 'Tipo de Treino removido com sucesso.'], 200);
    }
}

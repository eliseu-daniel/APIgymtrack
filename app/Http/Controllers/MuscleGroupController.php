<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMuscleGroupRequest;
use App\Models\MuscleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MuscleGroupController extends Controller
{
    public function index()
    {
        $muscleGroups = Cache::remember('muscle_groups:all', 86400, function () {
            return MuscleGroup::all();
        });

        return response()->json(['status' => true, 'MuscleDatas:' => $muscleGroups], 200);
    }

    public function create()
    {
        //
    }

    public function store(CreateMuscleGroupRequest $request)
    {
        $validatedMuscleGroup = $request->validated();
        $muscleGroup = MuscleGroup::create($validatedMuscleGroup);
        Cache::forget('muscle_groups:all');
        return response()->json(['status' => true, 'message' => 'Grupo Muscular criado com sucesso', 'MuscleData' => $muscleGroup], 201);
    }

    public function show(string $id)
    {
        $muscleGroup = Cache::remember("muscle_groups:{$id}", 86400, function () use ($id) {
            return MuscleGroup::find($id);
        });

        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        return response()->json(['status' => true, 'MuscleData' => $muscleGroup], 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CreateMuscleGroupRequest $request, string $id)
    {
        $muscleGroup = MuscleGroup::find($id);
        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        $validatedMuscleGroup = $request->validated();
        MuscleGroup::where('id', $id)->update($validatedMuscleGroup);
        Cache::forget('muscle_groups:all');
        Cache::forget("muscle_groups:{$id}");
        return response()->json(['status' => true, 'message' => 'Grupo Muscular atualizado com sucesso'], 200);
    }

    public function destroy(string $id)
    {
        $muscleGroup = MuscleGroup::find($id);
        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        MuscleGroup::where('id', $id)->delete();
        Cache::forget('muscle_groups:all');
        Cache::forget("muscle_groups:{$id}");
        return response()->json(['status' => true, 'message' => 'Grupo Muscular deletado com sucesso'], 200);
    }
}

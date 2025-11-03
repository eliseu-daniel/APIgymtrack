<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMuscleGroupRequest;
use App\Models\MuscleGroup;
use Illuminate\Http\Request;

class MuscleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'MuscleDatas:' => MuscleGroup::all()], 200);
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
    public function store(CreateMuscleGroupRequest $request)
    {
        $validatedMuscleGroup = $request->validated();
        $muscleGroup = MuscleGroup::create($validatedMuscleGroup);
        return response()->json(['status' => true, 'message' => 'Grupo Muscular criado com sucesso', 'MuscleData' => $muscleGroup], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $muscleGroup = MuscleGroup::find($id);
        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        return response()->json(['status' => true, 'MuscleData' => $muscleGroup], 200);
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
    public function update(CreateMuscleGroupRequest $request, string $id)
    {
        $muscleGroup = MuscleGroup::find($id);
        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        $validatedMuscleGroup = $request->validated();
        $muscleGroup = MuscleGroup::where('id', $id)->update($validatedMuscleGroup);
        return response()->json(['status' => true, 'message' => 'Grupo Muscular atualizado com sucesso', 'MuscleData' => $muscleGroup], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $muscleGroup = MuscleGroup::find($id);
        if (!$muscleGroup) {
            return response()->json(['status' => false, 'message' => 'Grupo Muscular não encontrado'], 404);
        }
        MuscleGroup::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Grupo Muscular deletado com sucesso'], 200);
    }
}

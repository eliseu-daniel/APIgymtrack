<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutItemRequest;
use App\Models\WorkoutItem;

class WorkoutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'ItemWorkoutData' => WorkoutItem::all()], 200);
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
    public function store(CreateWorkoutItemRequest $request)
    {
        $dataItemWorkout = $request->validated();
        $itemWorkout = WorkoutItem::create($dataItemWorkout);
        return response()->json(['status' => true, 'message' => 'Item de treino criado com sucesso!', 'ItemWorkoutData' => $itemWorkout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $itemWorkout = WorkoutItem::find($id);
        if (!$itemWorkout) {
            return response()->json(['status' => false, 'message' => 'Item de treino não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'ItemWorkoutData' => $itemWorkout], 200);
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
    public function update(CreateWorkoutItemRequest $request, string $id)
    {
        $itemWorkout = WorkoutItem::find($id);
        if (!$itemWorkout) {
            return response()->json(['status' => false, 'message' => 'Item de treino não encontrado.'], 404);
        }
        $itemWorkout->update(['is_active' => false]);

        $newItemData = $request->validated();
        $newData = WorkoutItem::create($newItemData);

        return response()->json(['status' => true, 'message' => 'Item de treino atualizado com sucesso!', 'ItemWorkoutData' => $newData], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itemWorkout = WorkoutItem::find($id);
        if (!$itemWorkout) {
            return response()->json(['status' => false, 'message' => 'Item de treino não encontrado.'], 404);
        }
        $itemWorkout->update(['is_active' => false]);

        return response()->json(['status' => true, 'message' => 'Item desativado com sucesso'], 200);
    }
}

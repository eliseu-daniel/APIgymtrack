<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true, 'Exercises' => Exercise::select('exercises.*', 'muscle_groups.*')
            ->join('muscle_groups', 'muscle_groups.id', '=', 'exercises.muscle_group_id')
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
    public function store(CreateExerciseRequest $request)
    {
        $validatedExercises = $request->validated();
        $exercise = Exercise::create($validatedExercises);
        return response()->json(['status' => true, 'message:' => 'Exercício criado com sucesso.', 'Exercise:' => $exercise], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exercise = Exercise::select('exercises.*', 'muscle_groups.*')
            ->join('muscle_groups', 'muscle_groups.id', '=', 'exercises.muscle_group_id')
            ->where('exercises.id', $id)
            ->first();
        if (!$exercise) {
            return response()->json(['status' => false, 'message:' => 'Exercício não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'Exercise:' => $exercise], 200);
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
    public function update(CreateExerciseRequest $request, string $id)
    {
        $exercise = Exercise::find($id);
        if (!$exercise) {
            return response()->json(['status' => false, 'message:' => 'Exercício não encontrado.'], 404);
        }
        $validatedExercises = $request->validated();
        $exerciseUpdated = Exercise::where('id', $id)->update($validatedExercises);
        return response()->json(['status' => true, 'message:' => 'Exercício atualizado com sucesso.', 'Exercise:' => $exerciseUpdated], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exercise = Exercise::delete($id);
        return response()->json(['status' => true, 'message:' => 'Exercício excluído com sucesso.'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Cache::remember('exercises:all', 86400, function () {
            return Exercise::select(
                'exercises.id as exercise_id',
                'exercises.*',
                'muscle_groups.id as muscle_group_id',
                'muscle_groups.muscle_group as muscle_group_name'
            )
                ->join('muscle_groups', 'muscle_groups.id', '=', 'exercises.muscle_group_id')
                ->get();
        });

        return response()->json(['status' => true, 'Exercises' => $exercises], 200);
    }

    public function create()
    {
        //
    }

    public function store(CreateExerciseRequest $request)
    {
        $validatedExercises = $request->validated();
        $exercise = Exercise::create($validatedExercises);
        Cache::forget('exercises:all');
        return response()->json(['status' => true, 'message:' => 'Exercício criado com sucesso.', 'Exercise:' => $exercise], 201);
    }

    public function show(string $id)
    {
        $exercise = Cache::remember("exercises:{$id}", 86400, function () use ($id) {
            return Exercise::select(
                'exercises.id as exercise_id',
                'exercises.*',
                'muscle_groups.id as muscle_group_id',
                'muscle_groups.muscle_group as muscle_group_name'
            )
                ->join('muscle_groups', 'muscle_groups.id', '=', 'exercises.muscle_group_id')
                ->where('exercises.id', $id)
                ->first();
        });

        if (!$exercise) {
            return response()->json(['status' => false, 'message:' => 'Exercício não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'Exercise:' => $exercise], 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CreateExerciseRequest $request, string $id)
    {
        $exercise = Exercise::find($id);
        if (!$exercise) {
            return response()->json(['status' => false, 'message:' => 'Exercício não encontrado.'], 404);
        }
        $validatedExercises = $request->validated();
        Exercise::where('id', $id)->update($validatedExercises);
        Cache::forget('exercises:all');
        Cache::forget("exercises:{$id}");
        return response()->json(['status' => true, 'message:' => 'Exercício atualizado com sucesso.'], 200);
    }

    public function destroy(string $id)
    {
        Exercise::destroy($id);
        Cache::forget('exercises:all');
        Cache::forget("exercises:{$id}");
        return response()->json(['status' => true, 'message:' => 'Exercício excluído com sucesso.'], 200);
    }
}

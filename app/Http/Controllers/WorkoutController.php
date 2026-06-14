<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutRequest;
use App\Services\WorkoutService;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function __construct(
        private WorkoutService $workoutService
    ) {}

    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        return response()->json([
            'status' => true,
            'WorkoutData' => $this->workoutService->getWorkoutsForEducator($idEducator, $perPage)
        ], 200);
    }

    public function store(CreateWorkoutRequest $request)
    {
        $workout = $this->workoutService->createWorkout($request->validated());
        return response()->json(['status' => true, 'message:' => 'Treino criado com sucesso', 'workout' => $workout], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $workout = $this->workoutService->getWorkoutForEducator($idEducator, (int) $id);

        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        return response()->json(['status' => true, 'workout' => $workout], 200);
    }

    public function update(CreateWorkoutRequest $request, string $id)
    {
        $workout = \App\Models\Workout::find($id);
        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }

        $this->workoutService->updateWorkout((int) $id, $request->validated());
        return response()->json(['status' => true, 'message' => 'Treino atualizado com sucesso'], 200);
    }

    public function destroy(string $id)
    {
        $result = $this->workoutService->deleteWorkout((int) $id);
        if ($result === null) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        return response()->json(['status' => true, 'message' => 'Treino deletado com sucesso'], 200);
    }

    public function getForPacientWorkout()
    {
        $idPatient = request()->user()->id;
        return response()->json([
            'status' => true,
            'WorkoutData' => $this->workoutService->getWorkoutsForPatient($idPatient)
        ], 200);
    }
}

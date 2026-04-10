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
        $idEducator = request()->user()->id;
        $workouts = Workout::with(['patient', 'workoutType'])
            ->whereHas('patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($workout) {
                $workoutArray = $workout->toArray();
                $workoutArray['workout_id'] = $workout->id;
                $workoutArray['patient_id'] = $workout->patient_id;
                $workoutArray['name'] = $workout->patient['name'] ?? null;
                $workoutArray['workout_type_id'] = $workout->workout_type_id;
                $workoutArray['workout_type_name'] = $workout->workoutType['workout_type'] ?? null;
                unset($workoutArray['patient'], $workoutArray['workout_type']);
                return $workoutArray;
            });

        return response()->json(['status' => true, 'WorkoutData' => $workouts], 200);
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
        $idEducator = $request->user()->id;
        $workoutValidated = $request->validated();

        $isPatientValid = \App\Models\Patient::whereHas('registrations', function ($query) use ($idEducator) {
            $query->where('educator_id', $idEducator);
        })->where('id', $workoutValidated['patient_id'])->exists();

        if (!$isPatientValid) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado ou não pertence a este educador'], 403);
        }

        $workout = Workout::create($workoutValidated);
        return response()->json(['status' => true, 'message:' => 'Treino criado com sucesso', 'workout' => $workout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $workout = Workout::with(['patient', 'workoutType'])
            ->whereHas('patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->first();

        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }

        $workoutArray = $workout->toArray();
        $workoutArray['workout_id'] = $workout->id;
        $workoutArray['patient_id'] = $workout->patient_id;
        $workoutArray['name'] = $workout->patient['name'] ?? null;
        $workoutArray['workout_type_id'] = $workout->workout_type_id;
        $workoutArray['workout_type_name'] = $workout->workoutType['workout_type'] ?? null;
        unset($workoutArray['patient'], $workoutArray['workout_type']);

        return response()->json(['status' => true, 'workout' => $workoutArray], 200);
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
        $idEducator = $request->user()->id;
        $workout = Workout::whereHas('patient.registrations', function ($query) use ($idEducator) {
            $query->where('educator_id', $idEducator);
        })->where('id', $id)->first();

        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        $workoutValidated = $request->validated();
        $workout->update($workoutValidated);
        return response()->json(['status' => true, 'message' => 'Treino atualizado com sucesso', 'workout' => $workout], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $idEducator = request()->user()->id;
        $workout = Workout::whereHas('patient.registrations', function ($query) use ($idEducator) {
            $query->where('educator_id', $idEducator);
        })->where('id', $id)->first();

        if (!$workout) {
            return response()->json(['status' => false, 'message' => 'Treino não encontrado'], 404);
        }
        $workout->delete();
        return response()->json(['status' => true, 'message' => 'Treino deletado com sucesso'], 200);
    }

    public function getForPacientWorkout()
    {
        $idPatient = request()->user()->id;
        $workouts = Workout::with(['patient', 'workoutType'])
            ->where('patient_id', $idPatient)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($workout) {
                $workoutArray = $workout->toArray();
                $workoutArray['patient_id'] = $workout->patient_id;
                $workoutArray['name'] = $workout->patient['name'] ?? null;
                $workoutArray['workout_type_id'] = $workout->workout_type_id;
                $workoutArray['workout_type_name'] = $workout->workoutType['workout_type'] ?? null;
                unset($workoutArray['patient'], $workoutArray['workout_type']);
                return $workoutArray;
            });

        return response()->json(['status' => true, 'WorkoutData' => $workouts], 200);
    }
}

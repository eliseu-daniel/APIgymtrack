<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutItemRequest;
use App\Jobs\NotifyPatientWorkoutItemConfirmedJob;
use App\Models\WorkoutItem;
use Symfony\Component\HttpFoundation\Request;

class WorkoutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'ItemWorkoutData' => WorkoutItem::select(
                'workout_items.id as workout_item_id',
                'workout_items.*',
                'exercises.exercise as exercise_name'
            )
                ->join('exercises', 'workout_items.exercise_id', '=', 'exercises.id')
                ->join('workouts', 'workout_items.workout_id', '=', 'workouts.id')
                ->join('patients', 'workouts.patient_id', '=', 'patients.id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('patient_registrations.educator_id', request()->user()->id)
                ->get()
        ], 200);
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
        $idEducator = request()->user()->id;

        $dataItemWorkout = $request->validated();
        $itemWorkout = WorkoutItem::create($dataItemWorkout);

        if ($itemWorkout && $itemWorkout->send_notification) {
            $data = WorkoutItem::query()
                ->select([
                    'workout_items.id as workoutItem_id',
                    'patients.id as patient_id',
                    'patients.name as patient_name',
                    'patient_registrations.educator_id as educator_id'
                ])
                ->join('workouts', 'workouts.id', '=', 'workout_items.workout_id')
                ->join('patients', 'patients.id', '=', 'workouts.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('workout_items.id', $itemWorkout->workout_items_id)
                ->where('patient_registrations.educator_id', $idEducator)
                ->first();

            if ($data) {
                NotifyPatientWorkoutItemConfirmedJob::dispatch(
                    (int) $itemWorkout->id,
                    (int) $data->patient_id,
                    (int) $data->educator_id
                );
            }
        }

        return response()->json(['status' => true, 'message' => 'Item de treino criado com sucesso!', 'ItemWorkoutData' => $itemWorkout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $itemWorkout = WorkoutItem::select('workout_items.*', 'exercises.exercise as exercise_name')
            ->join('exercises', 'workout_items.exercise_id', '=', 'exercises.id')
            ->join('workouts', 'workout_items.workout_id', '=', 'workouts.id')
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('workout_items.id', $id)
            ->where('patient_registrations.educator_id', request()->user()->id)
            ->first();
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

        if (isset($itemWorkout->send_notification) && $itemWorkout->send_notification) {
            NotifyPatientWorkoutItemConfirmedJob::dispatch(
                (int) $newData->id,
                (int) $newData->patient_id
            );
        }

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

    public function notifiedForPatient(Request $request)
    {
        $patientId = $request->user()->id;

        $data = WorkoutItem::query()
            ->select([
                'workout_items.id as workout_item_id',
                'workout_items.send_notification',
                'workout_items.created_at',
                'workouts.id as workout_id',
            ])
            ->join('workouts', 'workouts.id', '=', 'workout_items.workout_id')
            ->where('workouts.patient_id', $patientId)
            ->where('workout_items.send_notification', 1)
            ->orderByDesc('workout_items.created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'workout-item-' . $item->workout_item_id,
                    'type' => 'workout-item',
                    'title' => 'Nova atualização no treino',
                    'message' => 'Seu treino foi atualizado.',
                    'created_at' => $item->created_at,
                    'read' => false,
                    'workout_id' => $item->workout_id,
                    'workout_item_id' => $item->workout_item_id,
                ];
            })
            ->values();

        return response()->json($data, 200);
    }

    public function getForPacientWorkoutItem()
    {
        $idPatient = request()->user()->id;
        return response()->json([
            'status' => true,
            'ItemWorkoutData' => WorkoutItem::select(
                'workout_items.id as workout_item_id',
                'workout_items.*',
                'exercises.exercise as exercise_name'
            )
                ->join('exercises', 'workout_items.exercise_id', '=', 'exercises.id')
                ->join('workouts', 'workout_items.workout_id', '=', 'workouts.id')
                ->where('workouts.patient_id', $idPatient)
                ->orderBy('workout_items.updated_at', 'desc')
                ->get()
        ], 200);
    }
}

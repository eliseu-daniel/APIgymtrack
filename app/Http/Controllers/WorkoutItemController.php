<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutItemRequest;
use App\Jobs\NotifyPatientWorkoutItemConfirmedJob;
use App\Models\WorkoutItem;
use Illuminate\Http\Request;

class WorkoutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;
        $items = WorkoutItem::with(['exercise', 'workout.patient'])
            ->whereHas('workout.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($item) {
                $itemArray = $item->toArray();
                $itemArray['workout_item_id'] = $item->id;
                $itemArray['exercise_name'] = $item->exercise['exercise'] ?? null;
                unset($itemArray['exercise'], $itemArray['workout']);
                return $itemArray;
            });

        return response()->json([
            'status' => true,
            'ItemWorkoutData' => $items
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
            $itemWithWorkout = WorkoutItem::with('workout.patient.registrations')->find($itemWorkout->id);

            if ($itemWithWorkout && $itemWithWorkout->workout && $itemWithWorkout->workout->patient) {
                $registration = $itemWithWorkout->workout->patient->registrations->where('educator_id', $idEducator)->first();
                if ($registration) {
                    NotifyPatientWorkoutItemConfirmedJob::dispatch(
                        (int) $itemWorkout->id,
                        (int) $itemWithWorkout->workout->patient_id,
                        (int) $registration->educator_id
                    );
                }
            }
        }

        return response()->json(['status' => true, 'message' => 'Item de treino criado com sucesso!', 'ItemWorkoutData' => $itemWorkout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $idEducator = request()->user()->id;
        $itemWorkout = WorkoutItem::with(['exercise', 'workout.patient'])
            ->whereHas('workout.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$itemWorkout) {
            return response()->json(['status' => false, 'message' => 'Item de treino não encontrado.'], 404);
        }

        $itemArray = $itemWorkout->toArray();
        $itemArray['workout_item_id'] = $itemWorkout->id;
        $itemArray['exercise_name'] = $itemWorkout->exercise['exercise'] ?? null;
        unset($itemArray['exercise'], $itemArray['workout']);

        return response()->json(['status' => true, 'ItemWorkoutData' => $itemArray], 200);
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

        if (isset($newData->send_notification) && $newData->send_notification) {
            $itemWithWorkout = WorkoutItem::with('workout.patient.registrations')->find($newData->id);
            $idEducator = request()->user()->id;

            if ($itemWithWorkout && $itemWithWorkout->workout && $itemWithWorkout->workout->patient) {
                $registration = $itemWithWorkout->workout->patient->registrations->where('educator_id', $idEducator)->first();
                if ($registration) {
                    NotifyPatientWorkoutItemConfirmedJob::dispatch(
                        (int) $newData->id,
                        (int) $itemWithWorkout->workout->patient_id,
                        (int) $registration->educator_id
                    );
                }
            }
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

        $data = \App\Models\Notification::query()
            ->where('patient_id', $patientId)
            ->where('type', 'workout')
            ->orderByDesc('created_at')
            ->where('read', false)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de treino encontrada.'], 200);
        }
        
        return response()->json($data, 200);
    }

    public function getForPacientWorkoutItem()
    {
        $idPatient = request()->user()->id;
        $items = WorkoutItem::with('exercise')
            ->whereHas('workout', function ($query) use ($idPatient) {
                $query->where('patient_id', $idPatient);
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                $itemArray = $item->toArray();
                $itemArray['workout_item_id'] = $item->id;
                $itemArray['exercise_name'] = $item->exercise['exercise'] ?? null;
                unset($itemArray['exercise'], $itemArray['workout']);
                return $itemArray;
            });

        return response()->json([
            'status' => true,
            'ItemWorkoutData' => $items
        ], 200);
    }
}

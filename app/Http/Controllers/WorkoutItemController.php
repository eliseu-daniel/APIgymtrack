<?php

namespace App\Http\Controllers;

use App\Events\WorkoutItemConfirmed;
use App\Http\Requests\CreateWorkoutItemRequest;
use App\Models\WorkoutItem;
use App\Services\NotificationService;
use App\Services\WorkoutService;
use Illuminate\Http\Request;

class WorkoutItemController extends Controller
{
    public function __construct(
        private WorkoutService $workoutService,
        private NotificationService $notificationService
    ) {}

    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        return response()->json([
            'status' => true,
            'ItemWorkoutData' => $this->workoutService->getWorkoutItems($idEducator, $perPage)
        ], 200);
    }

    public function store(CreateWorkoutItemRequest $request)
    {
        $idEducator = $request->user()->id;

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
                ->where('workout_items.id', $itemWorkout->id)
                ->where('patient_registrations.educator_id', $idEducator)
                ->first();

            if ($data) {
                WorkoutItemConfirmed::dispatch(
                    (int) $itemWorkout->id,
                    (int) $data->patient_id,
                    (int) $data->educator_id
                );
            }
        }

        return response()->json(['status' => true, 'message' => 'Item de treino criado com sucesso!', 'ItemWorkoutData' => $itemWorkout], 201);
    }

    public function show(string $id)
    {
        $itemWorkout = WorkoutItem::select('workout_items.*', 'exercises.exercise as exercise_name')
            ->join('exercises', 'workout_items.exercise_id', '=', 'exercises.id')
            ->join('workouts', 'workout_items.workout_id', '=', 'workouts.id')
            ->join('patients', 'workouts.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('workout_items.id', $id)
            ->where('patient_registrations.educator_id', request()->user()->id)
            ->where('workout_items.is_active', true)
            ->first();

        if (!$itemWorkout) {
            return response()->json(['status' => false, 'message' => 'Item de treino não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'ItemWorkoutData' => $itemWorkout], 200);
    }

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
                ->where('workout_items.id', $newData->id)
                ->where('patient_registrations.educator_id', request()->user()->id)
                ->first();

            if ($data) {
                WorkoutItemConfirmed::dispatch(
                    (int) $newData->id,
                    (int) $data->patient_id,
                    (int) $data->educator_id
                );
            }
        }

        return response()->json(['status' => true, 'message' => 'Item de treino atualizado com sucesso!', 'ItemWorkoutData' => $newData], 200);
    }

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
        $data = $this->notificationService->getPatientNotifications($patientId, 'workout');

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de treino encontrada.'], 200);
        }

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

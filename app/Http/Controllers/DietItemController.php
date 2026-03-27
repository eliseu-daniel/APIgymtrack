<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietItemRequest;
use App\Jobs\NotifyPatientDietItemConfirmedJob;
use App\Models\DietItem;
use Illuminate\Http\Request;

class DietItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;
        return response()->json([
            'status' => true,
            'message' => DietItem::select(
                'diet_items.id as diet_item_id',
                'diets.id as diet_id',
                'food.id as food_id',
                'patients.name',
                'food.name as food_name',
                'diet_items.*',
                'meals.id as meal_id',
                'meals.name as meal_name',
            )
                ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
                ->join('patients', 'patients.id', '=', 'diets.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->join('food', 'food.id', '=', 'diet_items.food_id')
                ->join('meals', 'meals.id', '=', 'diet_items.meals_id')
                ->where('patient_registrations.educator_id', $idEducator)
                ->where('diet_items.is_active', true)
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
    public function store(CreateDietItemRequest $request)
    {
        $idEducator = request()->user()->id;

        $validator = $request->validated();
        $dietItem = DietItem::create($validator);

        if ($dietItem->send_notification = true) {
            $itemWithDiet = DietItem::query()
                ->select('diet_items.id', 'diets.patient_id', 'patient_registrations.educator_id')
                ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
                ->join('patients', 'patients.id', '=', 'diets.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('patient_registrations.educator_id', $idEducator)
                ->where('diet_items.id', $dietItem->id)
                ->first();

            if ($itemWithDiet) {
                NotifyPatientDietItemConfirmedJob::dispatch(
                    (int) $dietItem->id,
                    (int) $itemWithDiet->patient_id,
                    (int) $itemWithDiet->educator_id
                );
            }
        }

        return response()->json(['status' => true, 'message' => 'Item de dieta criado com sucesso.', 'data' => $dietItem], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $dietItem = DietItem::select(
            'diet_items.id as diet_item_id',
            'diets.id as diet_id',
            'food.id as food_id',
            'patients.name',
            'food.name as food_name',
            'meals.id as meal_id',
            'meals.name as meal_name',
            'diet_items.*',
        )
            ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->join('food', 'food.id', '=', 'diet_items.food_id')
            ->join('meals', 'meals.id', '=', 'diet_items.meals_id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('diet_items.id', $id)
            ->where('diet_items.is_active', true)
            ->first();

        if (!$dietItem) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }

        return response()->json(['status' => true, 'message' => $dietItem]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateDietItemRequest $request, string $id)
    {
        $idEducator = request()->user()->id;

        $item = DietItem::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item de dieta não encontrado.'
            ], 404);
        }

        $item->update(['is_active' => false]);

        $validated = $request->validated();

        $newItem = DietItem::create($validated);

        if ($newItem->send_notification = true) {
            $itemWithDiet = DietItem::query()
                ->select('diet_items.id', 'diets.patient_id', 'patient_registrations.educator_id')
                ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
                ->join('patients', 'patients.id', '=', 'diets.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('patient_registrations.educator_id', $idEducator)
                ->where('diet_items.id', $newItem->id)
                ->first();

            if ($itemWithDiet) {
                NotifyPatientDietItemConfirmedJob::dispatch(
                    (int) $newItem->id,
                    (int) $itemWithDiet->patient_id,
                    (int) $itemWithDiet->educator_id
                );
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Item de dieta atualizado com sucesso.',
            'data' => $item->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Item = DietItem::find($id);
        if (!$Item) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }
        $Item->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Item de dieta desativado com sucesso.'], 200);
    }

    public function notifiedForPatient(Request $request)
    {
        $patientId = $request->user()->id;

        $data = \App\Models\Notification::query()
            ->where('patient_id', $patientId)
            ->where('type', 'diet')
            ->orderByDesc('created_at')
            ->where('read', false)
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de dieta encontrada.'], 404);
        }

        return response()->json($data, 200);
    }

    public function getForPacientDietItem()
    {
        $idPatient = request()->user()->id;

        $items = DietItem::select(
            'diet_items.id as diet_item_id',
            'diet_items.*',
            'food.name as food_name',
            'meals.id as meal_id',
            'meals.name as meal_name'
        )
            ->join('food', 'diet_items.food_id', '=', 'food.id')
            ->join('diets', 'diet_items.diet_id', '=', 'diets.id')
            ->join('meals', 'diet_items.meals_id', '=', 'meals.id')
            ->where('diets.patient_id', $idPatient)
            ->orderBy('meals.id', 'asc')
            ->orderBy('diet_items.created_at', 'asc')
            ->get();

        $grouped = $items->groupBy('meal_name')->map(function ($group) {
            return $group->map(function ($item) {
                unset(
                    $item->meal_id,
                    $item->meal_name,
                );
                return $item;
            })->values();
        });

        return response()->json([
            'status' => true,
            'DietItemData' => $grouped
        ], 200);
    }
}

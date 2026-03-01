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
        return response()->json(['status' => true, 'message' => DietItem::select(
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
    public function store(CreateDietItemRequest $request)
    {
        $validator = $request->validated();
        $dietItem = DietItem::create($validator);
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
            ->first();

        if (!$dietItem) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }

        return response()->json(['status' => true, 'message' => $dietItem]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateDietItemRequest $request, string $id)
    {
        $Item = DietItem::find($id);
        if (!$Item) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }
        $validator = $request->validated();

        $dietItem = DietItem::where('id', $id)->update($validator);

        // se confirmou envio, dispara job
        if (array_key_exists('send_notification', $dietItem) && $dietItem['send_notification']) {
            NotifyPatientDietItemConfirmedJob::dispatch(
                (int) $id,
                (int) $dietItem->patient_id
            );
        }

        return response()->json(['status' => true, 'message' => 'Item de dieta atualizado com sucesso.', 'data' => $dietItem], 200);
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
        $DietItem = DietItem::where('id', $id)->update('is_active', false);
        return response()->json(['status' => true, 'message' => 'Item de dieta desativado com sucesso.'], 200);
    }

    public function notifiedForPatient(Request $request)
    {
        $idPatient = request()->user()->id;

        $data = DietItem::query()
            ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
            ->where('diets.patient_id', $idPatient)
            ->where('diet_items.send_notification', true)
            ->orderBy('diet_items.updated_at', 'desc')
            ->select([
                'diet_items.*',
                'diets.id as diet_id',
            ])
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
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
                    $item->diet_id,
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

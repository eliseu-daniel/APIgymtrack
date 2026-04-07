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
        $items = DietItem::with(['diet.patient', 'food', 'meal'])
            ->whereHas('diet.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($item) {
                $itemArray = $item->toArray();
                $itemArray['diet_item_id'] = $item->id;
                $itemArray['diet_id'] = $item->diet_id;
                $itemArray['food_id'] = $item->food_id;
                $itemArray['name'] = $item->diet->patient['name'] ?? null;
                $itemArray['food_name'] = $item->food['name'] ?? null;
                $itemArray['meal_id'] = $item->meals_id;
                $itemArray['meal_name'] = $item->meal['name'] ?? null;
                unset($itemArray['diet'], $itemArray['food'], $itemArray['meal']);
                return $itemArray;
            });

        return response()->json([
            'status' => true,
            'message' => $items
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

        if ($dietItem->send_notification == true) {
            $itemWithDiet = DietItem::with('diet.patient.registrations')->find($dietItem->id);

            if ($itemWithDiet && $itemWithDiet->diet && $itemWithDiet->diet->patient) {
                $registration = $itemWithDiet->diet->patient->registrations->where('educator_id', $idEducator)->first();
                if ($registration) {
                    NotifyPatientDietItemConfirmedJob::dispatch(
                        (int) $dietItem->id,
                        (int) $itemWithDiet->diet->patient_id,
                        (int) $registration->educator_id
                    );
                }
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
        $dietItem = DietItem::with(['diet.patient', 'food', 'meal'])
            ->whereHas('diet.patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$dietItem) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }

        $itemArray = $dietItem->toArray();
        $itemArray['diet_item_id'] = $dietItem->id;
        $itemArray['diet_id'] = $dietItem->diet_id;
        $itemArray['food_id'] = $dietItem->food_id;
        $itemArray['name'] = $dietItem->diet->patient['name'] ?? null;
        $itemArray['food_name'] = $dietItem->food['name'] ?? null;
        $itemArray['meal_id'] = $dietItem->meals_id;
        $itemArray['meal_name'] = $dietItem->meal['name'] ?? null;
        unset($itemArray['diet'], $itemArray['food'], $itemArray['meal']);

        return response()->json(['status' => true, 'message' => $itemArray]);
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

        if ($newItem->send_notification == true) {
            $itemWithDiet = DietItem::with('diet.patient.registrations')->find($newItem->id);

            if ($itemWithDiet && $itemWithDiet->diet && $itemWithDiet->diet->patient) {
                $registration = $itemWithDiet->diet->patient->registrations->where('educator_id', $idEducator)->first();
                if ($registration) {
                    NotifyPatientDietItemConfirmedJob::dispatch(
                        (int) $newItem->id,
                        (int) $itemWithDiet->diet->patient_id,
                        (int) $registration->educator_id
                    );
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Item de dieta atualizado com sucesso.',
            'data' => $newItem
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
            return response()->json(['status' => false, 'message' => 'Nenhuma notificação de dieta encontrada.'], 200);
        }

        return response()->json($data, 200);
    }

    public function getForPacientDietItem()
    {
        $idPatient = request()->user()->id;

        $items = DietItem::with(['food', 'meal'])
            ->whereHas('diet', function ($query) use ($idPatient) {
                $query->where('patient_id', $idPatient);
            })
            ->orderBy('meals_id', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $grouped = $items->groupBy(function ($item) {
            return $item->meal['name'] ?? 'Outros';
        })->map(function ($group) {
            return $group->map(function ($item) {
                $itemArray = $item->toArray();
                $itemArray['diet_item_id'] = $item->id;
                $itemArray['food_name'] = $item->food['name'] ?? null;
                unset($itemArray['food'], $itemArray['meal'], $itemArray['meal_id'], $itemArray['meal_name']);
                return $itemArray;
            })->values();
        });

        return response()->json([
            'status' => true,
            'DietItemData' => $grouped
        ], 200);
    }
}

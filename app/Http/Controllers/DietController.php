<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietRequest;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;

        $diets = Diet::with('patient')
            ->whereHas('patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($diet) {
                $dietArray = $diet->toArray();
                $dietArray['diet_id'] = $diet->id;
                $dietArray['patient_name'] = $diet->patient['name'] ?? null;
                unset($dietArray['patient']);
                return $dietArray;
            });

        return response()->json(['diets' => $diets], 200);
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
    public function store(CreateDietRequest $request)
    {
        $validated = $request->validated();
        $diet = Diet::create($validated);
        return response()->json(['status' => true, 'message' => 'Dieta criada com sucesso', 'data' => $diet], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;

        $diet = Diet::with('patient')
            ->whereHas('patient.registrations', function ($query) use ($idEducator) {
                $query->where('educator_id', $idEducator);
            })
            ->where('id', $id)
            ->first();

        if (!$diet) {
            return response()->json([
                'status' => false,
                'message' => 'Dieta não encontrada'
            ], 404);
        }

        $dietArray = $diet->toArray();
        $dietArray['patient_name'] = $diet->patient['name'] ?? null;
        unset($dietArray['patient']);

        return response()->json([
            'status' => true,
            'diet' => $dietArray
        ], 200);
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
    public function update(CreateDietRequest $request, string $id)
    {
        $diet = Diet::find($id);
        
        if (!$diet) {
            return response()->json([
                'status' => false,
                'message' => 'Dieta não encontrada'
            ], 404);
        }

        $validated = $request->validated();
        $diet->update($validated);
        
        return response()->json(['status' => true, 'message' => 'Dieta atualizada com sucesso', 'data' => $diet], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diet = Diet::find($id);
        $diet->update(['finalized_at' => now()]);
        return response()->json(['status' => true, 'message' => 'Dieta finalizada com sucesso'], 200);
    }

    public function finishDiet(Request $request)
    {
        $dateInit = $request->start_date;
        $dateFinish = $dateInit + 30;

        return $dateFinish;
    }

    public function getForPacientDiets()
    {
        $idPatient = auth('patient')->id();

        $diets = Diet::where('patient_id', $idPatient)
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($diet) {
                $dietArray = $diet->toArray();
                $dietArray['diet_id'] = $diet->id;
                return $dietArray;
            });

        return response()->json(['diets' => $diets], 200);
    }
}

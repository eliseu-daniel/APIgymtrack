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
        $diet = Diet::select('patients.name', 'diets.*', 'meals.*')
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('meals', 'diets.id', '=', 'meals.diet_id')
            ->orderBy('diets.start_date', 'desc')
            ->get();

        return response()->json(['diets' => $diet], 200);
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
        $request->validated();
        $diet = Diet::create();
        return response()->json(['status' => true, 'message' => 'Dieta criada com sucesso', 'data' => $diet], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $idPatient)
    {
        $diet = Diet::select('patients.name', 'diets.*', 'meals.*')
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('meals', 'diets.id', '=', 'meals.diet_id')
            ->where('patients.id', $idPatient)
            ->where('diets.id', $id)
            ->get();
        return response()->json(['status' => true, 'diet' => $diet], 200);
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
        $validated = $request->validate();
        $diet = Diet::where('id', $id)->update($validated);
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
}

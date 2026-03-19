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

        $diet = Diet::select('patients.name as patient_name', 'diets.id as diet_id', 'diets.*',)
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
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

        $diet = Diet::select([
            'diets.*',
            'patients.name as patient_name',
        ])
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('diets.id', $id)
            ->first();

        if (!$diet) {
            return response()->json([
                'status' => false,
                'message' => 'Dieta não encontrada'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'diet' => $diet
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

    public function getForPacientDiets()
    {
        $idPatient = auth('patient')->id();

        $diets = Diet::select('diets.id as diet_id', 'diets.*', )
            ->where('diets.patient_id', $idPatient)
            ->orderBy('diets.start_date', 'desc')
            ->get();

        return response()->json(['diets' => $diets], 200);
    }
}

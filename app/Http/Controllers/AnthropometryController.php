<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnthropometryRequest;
use App\Models\Anthropometry;
use Illuminate\Http\Request;

class AnthropometryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;

        return response()->json([
            'satus' => true,
            'data' => Anthropometry::select(
                'patients.name',
                'anthropometries.*'
            )
                ->join('patients', 'patients.id', '=', 'anthropometries.patient_id')
                ->where('patient_registrations.educator_id', $idEducator)
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
    public function store(CreateAnthropometryRequest $request)
    {
        $validator = $request->validate();
        $anthopometry = Anthropometry::create($validator);
        return response()->json(['status' => true, 'message' => 'Antropometria criada com sucesso', 'data' => $anthopometry], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $idPatient)
    {
        $idEducator = request()->user()->id;

        $anthopometry = Anthropometry::select(
            'patients.name',
            'anthropometries.*'
        )
            ->join('patients', 'patients.id', '=', 'anthropometries.patient_id', $idPatient)
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('anthropometries.id', $id)
            ->where('patients.id', $idPatient)
            ->get();
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }
        return response()->json(['status' => true, 'data' => $anthopometry], 200);
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
    public function update(CreateAnthropometryRequest $request, string $id)
    {
        $anthopometry = Anthropometry::find($id);
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Anthropometry not found'], 404);
        }

        $validator = $request->validate();

        $anthopometry = Anthropometry::where('id', $id)->update($validator);
        return response()->json(['status' => true, 'message' => 'Antropometria atualizada com sucesso', 'data' => $anthopometry], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anthopometry = Anthropometry::find($id);
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }

        $anthopometry->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Antropometria desativada com sucesso'], 200);
    }
}

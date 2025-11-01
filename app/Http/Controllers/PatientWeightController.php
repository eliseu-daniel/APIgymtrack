<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientWeightRequest;
use App\Models\PatientWeight;
use Illuminate\Http\Request;

class PatientWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weight = PatientWeight::all();
        return response()->json(['status' => true, 'weightAll' => $weight], 200);
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
    public function store(CreatePatientWeightRequest $request)
    {

        $validated = $request->validated();
        $weight = PatientWeight::create($validated);
        return response()->json(['status' => true, 'message' => 'Peso do paciente criado com sucesso', 'data' => $weight], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $weight = PatientWeight::find($id);
        return response()->json(['status' => true, 'data' => $weight], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePatientWeightRequest $request, string $id)
    {
        $validated = $request->validated();
        $weight = PatientWeight::where('id', $id)->update($validated);
        return response()->json(['status' => true, 'message' => 'Peso do paciente atualizado com sucesso', 'data' => $weight], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

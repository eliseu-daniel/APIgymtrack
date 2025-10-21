<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRegistrationRequest;
use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Services\DateServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class PatientRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patientRegistration = PatientRegistration::all();

        $formattedRegistrations = $patientRegistration->map(function ($registration) {
            $registration->start_date = DateServices::toBrazilianFormat($registration->start_date);
            $registration->end_date = DateServices::toBrazilianFormat($registration->end_date);

            return $registration;
        });

        return response()->json(['status' => true, 'Matrículas:' => $formattedRegistrations], 200);
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
    public function store(CreatePatientRegistrationRequest $request)
    {
        $validated = $request->validated();

        $patientRegistration = PatientRegistration::create($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula criado com sucesso', 'data' => $patientRegistration], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patientRegistration = PatientRegistration::find($id);
        return response()->json(['status' => true, 'data' => $patientRegistration], 200);
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
    public function update(CreatePatientRegistrationRequest $request, string $id)
    {
        $patientRegistration = PatientRegistration::find($id);
        $validated = $request->validated();

        $patientRegistration->update($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula atualizada com sucesso', 'data' => $patientRegistration], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patientRegistration = PatientRegistration::find($id);
        $patientRegistration->update('finalized', Date::now());

        return response()->json(['status' => true, 'message' => 'Matrícula finalizada com sucesso'], 200);
    }
}

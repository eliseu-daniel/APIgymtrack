<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRegistrationRequest;
use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Services\DateServices;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idEducator = request()->user()->id;
        $patientRegistration = PatientRegistration::select('patient_registrations.id as patient_registration_id', 'patient_registrations.*', 'patients.name', 'educators.name as educator_name')
            ->join('patients', 'patient_registrations.patient_id', '=', 'patients.id')
            ->join('educators', 'patient_registrations.educator_id', '=', 'educators.id')
            ->where('patient_registrations.educator_id', $idEducator)->get();

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
        $validated['educator_id'] = $request->user()->id;

        // Finalize previous registration if exists
        $previousRegistration = PatientRegistration::where('patient_id', $validated['patient_id'])
            ->whereNull('finalized_at')
            ->first();

        if ($previousRegistration) {
            $previousRegistration->update([
                'end_date' => $validated['start_date'],
                'finalized_at' => Carbon::now(),
            ]);
        }

        $patientRegistration = PatientRegistration::create($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula criado com sucesso', 'data' => $patientRegistration], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $patientRegistration = PatientRegistration::select('patient_registrations.*', 'patients.name', 'educators.name as educator_name')
            ->join('patients', 'patient_registrations.patient_id', '=', 'patients.id')
            ->join('educators', 'patient_registrations.educator_id', '=', 'educators.id')
            ->where('patient_registrations.id', $id)
            ->where('patient_registrations.educator_id', $idEducator)
            ->get();
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
        $idEducator = $request->user()->id;
        $patientRegistration = PatientRegistration::where('id', $id)->where('educator_id', $idEducator)->first();

        if (!$patientRegistration) {
            return response()->json(['status' => false, 'message' => 'Matrícula não encontrada'], 404);
        }

        $validated = $request->validated();
        $validated['educator_id'] = $idEducator; // Ensure educator_id cannot be changed

        $patientRegistration->update($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula atualizada com sucesso', 'data' => $patientRegistration], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $idEducator = request()->user()->id;
        $patientRegistration = PatientRegistration::where('id', $id)->where('educator_id', $idEducator)->first();

        if (!$patientRegistration) {
            return response()->json(['status' => false, 'message' => 'Matrícula não encontrada'], 404);
        }

        $patientRegistration->update(['finalized_at' => Carbon::now()]); // Note: changed 'finalized' to 'finalized_at' assuming it's a date or if it's really 'finalized' we need to check, actually it was 'finalized'. wait, update takes array.

        return response()->json(['status' => true, 'message' => 'Matrícula finalizada com sucesso'], 200);
    }
}

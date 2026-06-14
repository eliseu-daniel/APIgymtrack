<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRegistrationRequest;
use App\Models\PatientRegistration;
use App\Services\DateServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class PatientRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        $patientRegistration = PatientRegistration::select(
            'patient_registrations.id as patient_registration_id',
            'patient_registrations.*',
            'patients.name',
            'educators.name as educator_name'
        )
            ->join('patients', 'patient_registrations.patient_id', '=', 'patients.id')
            ->join('educators', 'patient_registrations.educator_id', '=', 'educators.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->paginate($perPage);

        $formattedRegistrations = collect($patientRegistration->items())->map(function ($registration) {
            $registration->start_date = DateServices::toBrazilianFormat($registration->start_date);
            $registration->end_date = DateServices::toBrazilianFormat($registration->end_date);
            return $registration;
        });

        return response()->json(['status' => true, 'Matrículas:' => $formattedRegistrations], 200);
    }

    public function store(CreatePatientRegistrationRequest $request)
    {
        $validated = $request->validated();
        $patientRegistration = PatientRegistration::create($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula criado com sucesso', 'data' => $patientRegistration], 201);
    }

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

    public function update(CreatePatientRegistrationRequest $request, string $id)
    {
        $patientRegistration = PatientRegistration::find($id);
        $validated = $request->validated();

        $patientRegistration->update($validated);
        return response()->json(['status' => true, 'message' => 'Matrícula atualizada com sucesso', 'data' => $patientRegistration], 200);
    }

    public function destroy(string $id)
    {
        $patientRegistration = PatientRegistration::find($id);
        $patientRegistration->update(['finalized_at' => Date::now()]);

        return response()->json(['status' => true, 'message' => 'Matrícula finalizada com sucesso'], 200);
    }
}

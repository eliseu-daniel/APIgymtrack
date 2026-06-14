<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientWeightRequest;
use App\Models\PatientWeight;
use Illuminate\Http\Request;

class PatientWeightController extends Controller
{
    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        $weight = PatientWeight::select('patient_weights.*', 'patients.id as patient_id', 'patients.name')
            ->join('patients', 'patient_weights.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->paginate($perPage);

        return response()->json(['status' => true, 'weightAll' => $weight], 200);
    }

    public function store(CreatePatientWeightRequest $request)
    {
        $validated = $request->validated();
        $weight = PatientWeight::create($validated);
        return response()->json(['status' => true, 'message' => 'Peso do paciente criado com sucesso', 'data' => $weight], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $weight = PatientWeight::select('patient_weights.*', 'patients.id as patient_id', 'patients.name')
            ->join('patients', 'patient_weights.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $idEducator)
            ->where('patient_weights.id', $id)->first();

        if (!$weight) {
            return response()->json(['status' => false, 'message' => 'Peso do paciente não encontrado'], 404);
        }

        return response()->json(['status' => true, 'data' => $weight], 200);
    }

    public function update(CreatePatientWeightRequest $request, string $id)
    {
        $validated = $request->validated();
        PatientWeight::where('id', $id)->update($validated);
        return response()->json(['status' => true, 'message' => 'Peso do paciente atualizado com sucesso', 'data' => $validated], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}

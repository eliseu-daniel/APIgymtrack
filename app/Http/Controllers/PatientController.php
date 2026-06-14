<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {}

    public function index()
    {
        return response()->json([
            'status' => true,
            "data" => $this->patientService->getAllPatients()
        ], 200);
    }

    public function store(CreatePatientRequest $request)
    {
        $patient = $this->patientService->createPatient($request->validated());

        return response()->json(['status' => true, 'message' => 'Paciente criado com sucesso.', 'data' => $patient], 201);
    }

    public function show(string $id)
    {
        $patient = $this->patientService->getPatient((int) $id);
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        $patient->birth_date = $patient->birth_date ? date('d/m/Y', strtotime($patient->birth_date)) : null;

        return response()->json(['status' => true, 'data' => $patient], 200);
    }

    public function update(CreatePatientRequest $request, string $id)
    {
        $patient = $this->patientService->updatePatient((int) $id, $request->validated());
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Paciente atualizado com sucesso.', 'data' => $patient], 200);
    }

    public function destroy(string $id)
    {
        $patient = $this->patientService->deactivatePatient((int) $id);
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Paciente desativado com sucesso.'], 200);
    }

    public function PatientsForEducator()
    {
        $idEducator = request()->user()->id;

        return response()->json([
            'status' => true,
            'data' => $this->patientService->getPatientsForEducator($idEducator)
        ], 200);
    }
}

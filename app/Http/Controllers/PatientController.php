<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Models\Patient;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return response()->json(['status' => true, "data" => $patients], 200);
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
    public function store(CreatePatientRequest $request)
    {

        if ($request->has('birth_date')) {
            $birthDate = $this->convertDateFormat($request->birth_date);
            if ($birthDate) {
                $request->merge(['birth_date' => $birthDate]);
            }
        }

        $patientValidated = $request->validate();

        $patient = Patient::create($patientValidated);

        return response()->json(['status' => true, 'message' => 'Paciente criado com sucesso.', 'data' => $patient], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        $patient->birth_date = $patient->birth_date ? date('d/m/Y', strtotime($patient->birth_date)) : null;

        return response()->json(['status' => true, 'data' => $patient], 200);
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
    public function update(CreatePatientRequest $request, string $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        if ($request->has('birth_date')) {
            $birthDate = $this->convertDateFormat($request->birth_date);
            if ($birthDate) {
                $request->merge(['birth_date' => $birthDate]);
            }
        }

        $patientValidated = $request->validate();

        $patient = Patient::where('id', $id)->update($patientValidated);

        return response()->json(['status' => true, 'message' => 'Paciente atualizado com sucesso.', 'data' => $patient], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['status' => false, 'message' => 'Paciente não encontrado.'], 404);
        }

        $patient->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Paciente desativado com sucesso.'], 200);
    }

    public function convertDateFormat($date)
    {
        if ($date) {
            $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
            if ($dateTime) {
                return $dateTime->format('Y-m-d');
            }
        }
    }
}

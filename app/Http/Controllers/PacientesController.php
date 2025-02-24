<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

use App\Models\Pacientes;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = Pacientes::where('idUsuario', auth()->id())->get();
        return response()->json(['data' =>$patient], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idUsuario'            => 'required|int',
            'nomePaciente'         => 'required|string|max:100',
            'emailPaciente'        => 'required|string|email|unique:pacientes,emailPaciente',
            'telefonePaciente'     => 'required|string|max:15',
            'nascimentoPaciente'   => 'required|date',
            'planoAcompanhamento'  => 'required|string|max:100|in:mensal,trimestral,semestral',
            'inicioAcompanhamento' => 'nullable|date',
            'sexoPaciente'         => 'string|in:F,M',
            'pagamento'            => 'string',
            'alergias'             => 'nullable|string|max:100'
        ]);

        $fimAcompanhamento = $this->calcEndDate($request);

        $patient = Pacientes::create(array_merge($validated, $fimAcompanhamento));

        return response()->json(['message' => 'Paciente cadastrado com sucesso!', 'data' =>$patient], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Pacientes::where('idPaciente', $id)->where('idUsuario', auth()->id())->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente não encontrado'], 404);
        }

        return response()->json($patient, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Pacientes::where('idPaciente', $id)->where('idUsuario', auth()->id())->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente não encontrado', 404]);
        }

        $validated = $request->validate([
            'idUsuario'            => 'required|int',
            'nomePaciente'         => 'required|string|max:100',
            'emailPaciente'        => 'required|string|email|unique:pacientes,emailPaciente,' . $id . ',idPaciente',
            'telefonePaciente'     => 'required|string|max:15',
            'nascimentoPaciente'   => 'required|date',
            'planoAcompanhamento'  => 'required|string|max:100|in:mensal,trimestral,semestral',
            'inicioAcompanhamento' => 'nullable|date',
            'sexoPaciente'         => 'string|in:F,M',
            'pagamento'            => 'string',
            'alergias'             => 'nullable|string|max:100'
        ]);

        $fimAcompanhamento = $this->calcEndDate($request);

        $patient->update(array_merge($validated, $fimAcompanhamento));

        return response()->json(['message' => 'Paciente Atualizado com sucesso!', 'data' =>$patient], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Pacientes::where('idPaciente', $id)->where('idUsuario', auth()->id())->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente não encontrado'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Paciente Deletado com sucesso!'], 200);
    }

    public function calcEndDate(Request $request)
    {
        $validated = $request->validate([
            'inicioAcompanhamento' => 'required|date',
            'planoAcompanhamento'            => 'required|in:mensal,trimestral,semestral'
        ]);

        $days = match ($request->planoAcompanhamento) {
            "mensal" => 30,
            "trimestral" => 90,
            "semestral" => 180,
            default => 0,
        };

        $fimAcompanhamento = null;

        if (!empty($request->planoAcompanhamento)) {
            $fimAcompanhamento = Carbon::parse($request->planoAcompanhamento)->addDays($days)->format('Y-m-d');
        }

        return ['fimAcompanhamento' => $fimAcompanhamento];

    }
}
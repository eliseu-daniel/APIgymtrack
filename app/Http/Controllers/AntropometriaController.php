<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Antropometria;

class AntropometriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Antropometria::join('pacientes', 'antropometria.idPaciente', '=', 'pacientes.idPaciente')
            ->select('antropometria.*', 'pacientes.nomePaciente')
            ->get();

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPaciente'      => 'required|int',
            'pesoInicial'     => 'required|numeric|min:0|max:300',
            'altura'          => 'required|numeric|min:0|max:300',
            'gorduraCorporal' => 'required|numeric|min:0|max:300',
            'nivelAtvFisica'  => 'nullable|string|max:50',
            'objetivo'        => 'nullable|string|max:50',
            'tmb'             => 'nullable|numeric|min:0|max:300',
            'getAntro'        => 'nullable|int',
            'lesoes'          => 'nullable|string|max:100'
        ]);

        $antro = Antropometria::create($validated);

        $antro->load('pacientes:idPaciente, nomePaciente');

        return response()->json(['message:' => 'Antropometria criada com sucesso', 'data' => $antro], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $antro = Antropometria::join('pacientes', 'antropometria.idPaciente', '=', 'pacientes.idPaciente')
            ->select('antropometria.*', 'pacientes.nomePaciente')
            ->where('idAntropometria', $id)->first();

        if (!$antro) {
            return response()->json(['error:' => 'Antropometria não existe'], 404);
        }

        return response()->json($antro, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $antro = Antropometria::where('idAntropometria', $id)->first();

        if (!$antro) {
            return response()->json(['error' => 'Paciente não encontrado'], 404);
        }

        $validated = $request->validate([
            'idPaciente'      => 'required|int',
            'pesoInicial'     => 'required|numeric|min:0|max:300',
            'altura'          => 'required|numeric|min:0|max:300',
            'gorduraCorporal' => 'required|numeric|min:0|max:300',
            'nivelAtvFisica'  => 'nullable|string|max:50',
            'objetivo'        => 'nullable|string|max:50',
            'tmb'             => 'nullable|numeric|min:0|max:300',
            'getAntro'        => 'nullable|int',
            'lesoes'          => 'nullable|string|max:100'
        ]);

        $antro->update($validated);

        $antro->load('pacientes:idPaciente, nomePaciente');

        return response()->json(['message' => 'Antropometria atualizada com sucesso', 'data' => $antro], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $antro = Antropometria::where('idAntropometria', $id)->first();

        if (!$antro) {
            return response()->json(['error' => 'Paciente não encontrado'], 404);
        }

        $antro->delete($id);

        return response()->json(['message' => 'Antropometria deletada com sucesso'], 200);
    }
}
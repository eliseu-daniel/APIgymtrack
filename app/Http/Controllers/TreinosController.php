<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Treinos;

class TreinosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Treinos::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPaciente'      => 'required|int',
            'idAntropometria' => 'required|int',
            'inicioTreino'    => 'required|date',
            'tipoTreino'      => 'nullable|string|max:50',
            'grupoMuscular'   => 'nullable|string|max:50',
            'seriesTreino'    => 'nullable|int',
            'repeticoesTreino'=> 'nullable|int',
            'cargaInicial'    => 'nullable|numeric',
            'cargaAtual'      => 'nullable|numeric',
            'tempoDescanso'   => 'nullable|string',
            'diaSemana'       => 'nullable|string',
            'linksExecucao'   => 'nullable|string'
        ]);

        $workout = Treinos::create($validated);

        return response()->json(['message' => 'Treino criado com sucesso.', 'data' => $workout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workout = Treinos::where('idTreino', $id)->first();

        if (!$workout) {
            return response()->json(['error' => 'Treino não encontrado'], 404);
        }

        return response()->json(['data' => $workout], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $workout = Treinos::where('idTreino', $id)->first();

        if (!$workout) {
            return response()->json(['error' => 'Treino não encontrado'], 404);
        }
        
        $validated = $request->validate([
            'idPaciente'      => 'required|int',
            'idAntropometria' => 'required|int',
            'inicioTreino'    => 'required|date',
            'tipoTreino'      => 'nullable|string|max:50',
            'grupoMuscular'   => 'nullable|string|max:50',
            'seriesTreino'    => 'nullable|int',
            'repeticoesTreino'=> 'nullable|int',
            'cargaInicial'    => 'nullable|numeric',
            'cargaAtual'      => 'nullable|numeric',
            'tempoDescanso'   => 'nullable|string',
            'diaSemana'       => 'nullable|string',
            'linksExecucao'   => 'nullable|string'
        ]);

        $workout->update($validated);

        return response()->json(['message' => 'Treino alterado com sucesso.', 'data' => $workout], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workout = Treinos::where('idTreino', $id)->first();

        if (!$workout) {
            return response()->json(['error' => 'Treino não encontrado'], 404);
        }   

        $workout->delete($id);

        return response()->json(['message' => 'Treino deletado com sucesso.'], 200);
    }
}

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
        $data = Treinos::join('pacientes', 'treinos.idPaciente', '=', 'pacientes.idPaciente')
            ->join('antropometria', 'treinos.idAntropometria', '=', 'antropometria.idAntropometria')
            ->select('treinos.*','antropometria.*', 'pacientes.nomePaciente', 'pacientes.planoAcompanhamento')
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

        // $workout = Treinos::where('treinos.idTreino', $workout->idTreino)
        //     ->join('pacientes', 'treinos.idPaciente', '=', 'pacientes.idPaciente')
        //     ->join('antropometria', 'treinos.idAntropometria', '=', 'antropometria.idAntropometria')
        //     ->select('treinos.*', 'antropometria.*', 'pacientes.nomePaciente', 'pacientes.planoAcompanhamento')
        //     ->first();

        $workout->load(['pacientes:idPaciente, nomePaciente, planoAcompanhamento', 'antropometria:idAntropometria']); //testar

        return response()->json(['message' => 'Treino criado com sucesso.', 'data' => $workout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workout = Treinos::join('pacientes', 'treinos.idPaciente', '=', 'pacientes.idPaciente')
            ->join('antropometria', 'treinos.idAntropometria', '=', 'antropometria.idAntropometria')
            ->where('treinos.idTreino', $id)
            ->where('pacientes.idUsuario', auth()->id())
            ->select('treinos.*','antropometria.*', 'pacientes.nomePaciente', 'pacientes.nomePaciente', 'pacientes.planoAcompanhamento')
            ->first();

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
        
        $validated = $request->validate([ // adicionar os novos campos do banco
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

        $workout->load(['pacientes:idPaciente,nomePaciente,planoAcompanhamento', 'antropometria']); //testar

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

        $workout->delete();

        return response()->json(['message' => 'Treino deletado com sucesso.'], 200);
    }
}

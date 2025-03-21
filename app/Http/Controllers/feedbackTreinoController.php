<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackTreino;

class FeedbackTreinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FeedbackTreino::join('pacientes', 'feedbacks.idPaciente', '=', 'pacientes.idPaciente')
        ->join('treinos', 'feedbacks.idTreino', '=', 'treinos.idTreino')
        ->select('treinos.*','pacientes.nomePaciente')
        ->get();

    if (!$data) {
        return response()->json(['mesasge' => 'Treino não encontrada'], 404);
    }
    
    return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = validate([
            'idTreino'           => 'required|int',
            'idPaciente'        => 'required|int',
            'comentario'        => 'nullable|string',
            'dataFeedback'      => 'nullable|date'
        ]);

        $workout = FeedbackTreino::create($validated);

        return response()->json(['message' => 'Feedback criado com sucesso', 'data' => $workout], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workout = FeedbackTreino::where($id)->first();

        if (!$workout) {
            return response()->json(['message' => 'Feedback não encontrado'], 404);
        }

        $workout->delete();

        return response()->json(['mesage' => 'Feedback apagado com sucesso'], 200);
    }
}

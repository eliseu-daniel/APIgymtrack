<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FeedbackDieta;

class FeedbackDietaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FeedbackDieta::join('pacientes', 'feedbackdieta.idPaciente', '=', 'pacientes.idPaciente')
        ->join('dietas', 'feedbackdieta.idDieta', '=', 'dietas.idDieta')
        ->select('dietas.*','pacientes.nomePaciente')
        ->get();

    if (!$data) {
        return response()->json(['mesasge' => 'Dieta não encontrada'], 404);
    }
    
    return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = validate([
            'idDieta'           => 'required|int',
            'idPaciente'        => 'required|int',
            'comentario'        => 'nullable|string',
            'dataFeedbackDieta' => 'nullable|date'
        ]);

        $diet = FeedbackDieta::create($validated);

        return response()->json(['message' => 'Feedback criado com sucesso', 'data' => $diet], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /*
        SELECT d.inicioDieta, a.pesoInicial, d.pesoAtual 
        FROM dietas d
        JOIN antropometria a ON d.idPaciente = a.idPaciente
        WHERE d.idPaciente = 10
        ORDER BY d.inicioDieta;
        */
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
        $diet = FeedbackDieta::where($id)->first();

        if (!$diet) {
            return response()->json(['message' => 'Feedback não encontrado'], 404);
        }

        $diet->delete();

        return response()->json(['mesage' => 'Feedback apagado com sucesso'], 200);
    }
}

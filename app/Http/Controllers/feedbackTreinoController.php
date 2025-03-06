<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackTreinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /*
        SELECT t.inicioTreino, t.nomeExercicio, t.cargaInicial, t.cargaAtual, t.repeticoesTreino
        FROM treinos t
        WHERE t.idPaciente = 10
        ORDER BY t.inicioTreino;
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
        //
    }
}

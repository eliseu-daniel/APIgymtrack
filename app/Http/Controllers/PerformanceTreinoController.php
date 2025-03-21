<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treinos;

class PerformanceTreinoController extends Controller
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
        $performance = Treinos::join('Pacientes', 'treinos.idPaciente', '=', 'Pacientes.idPaciente')
        ->select('treinos.cargaInicial', 'Pacientes.nomePaciente', 'treinos.cargaAtual')
        ->where('treinos.idPaciente', '=', $id)
        ->orderBy('treinos.inicioTreino')
        ->get();

        return response()->json(['data' => $performance], 200);
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

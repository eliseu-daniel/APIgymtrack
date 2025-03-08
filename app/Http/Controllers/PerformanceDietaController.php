<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceDietaController extends Controller
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
        //
    }
}

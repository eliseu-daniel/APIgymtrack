<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class feedbackDietaController extends Controller
{
    /*
        SELECT d.inicioDieta, a.pesoInicial, d.pesoAtual 
        FROM dietas d
        JOIN antropometria a ON d.idPaciente = a.idPaciente
        WHERE d.idPaciente = 10
        ORDER BY d.inicioDieta;
    */
}

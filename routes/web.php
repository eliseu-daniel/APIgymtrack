<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AntropometriaController,
    CalendarioController,
    DietasController,
    PacientesController,
    TreinosController,
    UsuariosController,
};

Route::get('/', function () {
    return view('welcome');
});


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

Route::post('login', [UsuariosController::class, 'verifyPw']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [UsuariosController::class, 'loggout']);

    Route::apiResource('usuarios', UsuariosController::class);
    
    Route::apiResource('pacientes', PacientesController::class);

    Route::apiResource('antropometria', AntropometriaController::class);

    Route::apiResource('dietas', DietasController::class);

    Route::apiResource('treinos', TreinosController::class);
    
    Route::apiResource('calendario', CalendarioController::class);
    
});


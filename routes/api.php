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

Route::prefix('v1')->group(function () {
    Route::apiResource('usuarios', UsuariosController::class);
    Route::post('usuarios/verifyPw', [UsuariosController::class, 'verifyPw']);
    
    Route::apiResource('pacientes', PacientesController::class);

    Route::apiResource('antropometria', AntropometriaController::class);


    Route::apiResource('dietas', DietasController::class);


    Route::apiResource('treinos', TreinosController::class);

    
    Route::apiResource('calendario', CalendarioController::class);
    
});


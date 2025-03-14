<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AntropometriaController,
    CalendarioController,
    DietasController,
    PacientesController,
    TreinosController,
    UsuariosController,
    PerformanceDietaController,
    PerformanceTreinoController
};

Route::post('login', [UsuariosController::class, 'verifyPw']);

Route::prefix('api')->middleware('auth:sanctum')->group(function () {

    Route::post('logout', [UsuariosController::class, 'logout'])->name('logout');

    Route::apiResource('usuarios', UsuariosController::class)->name('usuarios');
    
    Route::apiResource('pacientes', PacientesController::class)->name('pacientes');

    Route::apiResource('antropometria', AntropometriaController::class)->name('antropometria');

    Route::apiResource('dietas', DietasController::class)->name('dietas');

    Route::apiResource('treinos', TreinosController::class)->name('treinos');
    
    Route::apiResource('calendario', CalendarioController::class)->name('calendario');

    Route::apiResource('dietaPerformance', PerformanceDietaController::class)->name('dietaPerformance');

    Route::apiResource('treinoPerformance', PerformanceTreinoController::class)->name('treinoPerformance');
    
});


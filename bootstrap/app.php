<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->renderable(function (AuthenticationException $e, $request) {

            // Se for qualquer rota api/*, retorna JSON e impede redirect
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Usuário não autenticado. Faça login novamente.',
                    'error' => 'UNAUTHENTICATED',
                ], 401);
            }

            return null; // web continua padrão
        });
    })->create();

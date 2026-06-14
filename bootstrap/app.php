<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

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
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'status' => false,
                'message' => 'Usuário não autenticado. Faça login novamente.',
                'error' => 'UNAUTHENTICATED',
            ], 401)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Headers' => '*',
            ]);
        });

        $exceptions->renderable(function (Throwable $e, $request) {
            if (!$request->is('api/*')) {
                return null;
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'status' => false,
                    'errors' => $e->errors(),
                ], 422);
            }

            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            $jsonResponse = $status === 500
                ? response()->json(['status' => false, 'message' => 'Erro interno do servidor.'], 500)
                : response()->json(['status' => false, 'message' => $e->getMessage()], $status);

            $jsonResponse->headers->set('Access-Control-Allow-Origin', '*');
            $jsonResponse->headers->set('Access-Control-Allow-Methods', '*');
            $jsonResponse->headers->set('Access-Control-Allow-Headers', '*');

            return $jsonResponse;
        });
    })->create();

<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Override redirectTo to prevent redirect in API
     */
    protected function redirectTo(Request $request): ?string
    {
        // ✅ Se for API, NÃO redireciona
        if ($request->is('api/*')) {
            return null;
        }

        // se tiver web, pode redirecionar
        return route('login');
    }
}

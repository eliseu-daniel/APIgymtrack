<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthenticateRequest;
use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $educator = Educator::where('email', $request->email)->first();

        if (!$educator) {
            return response()->json([
                'message' => 'E-mail não encontrado. Verifique e tente novamente.'
            ], 404);
        }

        if (!Hash::check($request->password, $educator->password)) {
            return response()->json([
                'message' => 'Senha incorreta. Tente novamente.'
            ], 401);
        }

        if (!$educator->is_active) {
            return response()->json([
                'message' => 'Educador inativo. Entre em contato com o suporte.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'token' => $educator->createToken('api-token')->plainTextToken,
            'educator' => $educator,
        ], 200);
    }

    public function register(CreateAuthenticateRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $educator = Educator::create($data);

        return response()->json([
            // 'token' => $educator->createToken('api-token')->plainTextToken,
            'message' => 'Educador cadastrado com sucesso',
            'data' => $educator,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}

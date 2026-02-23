<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthenticateRequest;
use App\Models\Administrator;
use App\Models\Educator;
use App\Models\Patient;
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
        $user =
            auth()->user() // guard padrão (educator no seu caso)
            ?? auth('patient')->user()
            ?? auth('administrator')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }

    public function loginPatient(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $patient = Patient::where('email', $request->email)->first();

        if (!$patient) {
            return response()->json([
                'message' => 'E-mail não encontrado. Verifique e tente novamente.'
            ], 404);
        }

        if (!$patient->is_active) {
            return response()->json([
                'message' => 'Paciente inativo. Entre em contato com o suporte.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'token' => $patient->createToken('patient-token')->plainTextToken,
            'patient' => $patient,
        ], 200);
    }

    public function loginAdministrator(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $administrator = Administrator::where('email', $request->email)->first();

        if (!$administrator) {
            return response()->json([
                'message' => 'E-mail não encontrado. Verifique e tente novamente.'
            ], 404);
        }

        if (!Hash::check($request->password, $administrator->password)) {
            return response()->json([
                'message' => 'Senha incorreta. Tente novamente.'
            ], 401);
        }

        if (!$administrator->is_admin) {
            return response()->json([
                'message' => 'Você não é um administrador. Entre em contato com o suporte.'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'token' => $administrator->createToken('administrator-token')->plainTextToken,
            'administrator' => $administrator,
        ], 200);
    }
}

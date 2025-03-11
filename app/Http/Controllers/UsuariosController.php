<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Usuarios;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return Usuarios::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomeUsuario' => 'required|string|max:100',
            'telefoneUsuario' => 'required|string|max:15',
            'emailUsuario' => 'required|string|email|unique:usuarios,emailUsuario',
            'senhaUsuario' => 'required|string|min:6',
            'tipoUsuario' => 'required|in:admin,usuario',
            'tipoPlanoUsuario' => 'required|in:free,pago',
            'pagamentoUsuario' => 'required|in:S,N'
        ]);

        $users = Usuarios::create($validated);

        return response()->json(['message:' => 'Usuário criado com sucesso', 'data' => $users], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Usuarios::where('idUsuario',  $id)->first();
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        return response()->json(['data' => $user],  200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Usuarios::where('idUsuario', $id)->first();
        
        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $validated = $request->validate([
            'nomeUsuario'      => 'nullable|string|max:100',
            'telefoneUsuario'  => 'nullable|string|max:15',
            'emailUsuario'     => 'nullable|string|email|unique:usuarios,emailUsuario,' . $id . ',idUsuario',
            'senhaUsuario'     => 'nullable|string|min:6',
            'tipoUsuario'      => 'nullable|in:admin,usuario',
            'tipoPlanoUsuario' => 'nullable|in:free,pago',
            'pagamentoUsuario' => 'nullable|in:S,N'
        ]);

        $user->update($request->all());
        
        return response()->json(['message:' => 'Dados Atualizados com sucesso', 'data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Usuarios::where('idUsuario', $id)->first();

        if(!$user)
        {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $deleted = $user->delete($id);

        return response()->json(['message:' => 'Usuário deletado com sucesso'], 200);
    }

    public function verifyPw(Request $request){

        $request->validate([
            'emailUsuario' => 'required|email',
            'senhaUsuario' => 'required|string'
        ]);

        $user = Usuarios::where('emailUsuario', $request->emailUsuario)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        if (!Hash::check($request->senhaUsuario, $user->senhaUsuario)) {
            return response()->json(['message' => 'Senha incorreta'], 401);
        }

        $tokenApi = $user->createToken('tokenApi')->plainTextToken;

        return response()->json([
            'status'  => true,
            'token'   => $tokenApi,
            'message' => 'Login realizado com sucesso',
            'data'    => $user
        ], 200);

    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }
        
        $user->tokens()->delete();
        
        return response()->json(['status' => true,
        'message' => 'Logout realizado com sucesso'], 200);

    }
}

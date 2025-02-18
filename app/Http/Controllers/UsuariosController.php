<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'nomeUsuario     ' => 'required|string|max:100',
            'telefoneUsuario ' => 'required|string|max:15',
            'emailUsuario    ' => 'required|string|email|unique:usuarios,emailUsuario',
            'senhaUsuario    ' => 'required|string|min:6',
            'tipoUsuario     ' => 'required|in:admin,usuario',
            'tipoPlanoUsuario' => 'required|in:free,pago',
            'pagamentoUsuario' => 'required|in:S,N'
        ]);

        $users = Usuarios::create($validated);

        return response()->json($users);
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

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Usuarios::where('idUsuario', $id)->first();
        
        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado']);
        }

        $updated = $user->update($request->all());
        
        return response()->json(['message:' => 'Dados Atualizados com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verifyPw(Request $request){

        $emailUsuario = $request->input('emailUsuario');
        $senhaUsuario = $request->input('senhaUsuario');

        $user = Usuarios::where('emailUsuario', $emailUsuario)->first();

        if ($user) {
            if(Hash::check($senhaUsuario, $user->senhaUsuario)){
                return response()->json(['message'=>'senha correta'], 200);
            }
            else {
                return response()->json(['message'=>'senha incorreta'], 401);
            }
        }else {
            return response()->json(['message'=>'Usuário não encontrado'], 404);            
        }

    }
}

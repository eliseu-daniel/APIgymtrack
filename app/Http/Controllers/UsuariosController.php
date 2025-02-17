<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
      $users = Usuarios::getAll();

      return response()->json($users);
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

        return response()->json($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => true,'AdministratorsData' => Administrator::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $adm = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administrators',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'is_active' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean',
        ]);

        $adm = Administrator::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
            'is_admin' => $request->is_admin ?? false
        ]);

        return response()->json(['status' => true,'message' => 'Administrador criado com sucesso', 'Data' => $adm], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false,'message' => 'Administrador não encontrado'], 404);
        }
        return response()->json(['status' => true,'Data' => $adm], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false,'message' => 'Administrador não encontrado'], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:administrators,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'phone' => 'sometimes|string|max:15',
            'is_active' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean',
        ]);

        if (isset($request->password)) {
            $data = Hash::make($request->password);
        }

        $adm->update($data);

        return response()->json(['status' => true,'message' => 'Administrador atualizado com sucesso', 'Data' => $adm], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false,'message' => 'Administrador não encontrado'], 404);
        }
        
        $adm->update(['is_active' => false]);
        return response()->json(['status' => true,'message' => 'Administrador desativado com sucesso'], 200);
    }
}

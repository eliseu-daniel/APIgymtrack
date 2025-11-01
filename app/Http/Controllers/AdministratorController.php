<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdministratorRequest;
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
        return response()->json(['status' => true, 'AdministratorsData' => Administrator::all()], 200);
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
    public function store(CreateAdministratorRequest $request)
    {
        $validator = $request->validate();

        $adm = Administrator::create($validator, [
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['status' => true, 'message' => 'Administrador criado com sucesso', 'Data' => $adm], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false, 'message' => 'Administrador não encontrado'], 404);
        }
        return response()->json(['status' => true, 'Data' => $adm], 200);
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
    public function update(CreateAdministratorRequest $request, string $id)
    {
        $validator = $request->validate();

        $adm = Administrator::where('id', $id)->update($validator, [
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['status' => true, 'message' => 'Administrador atualizado com sucesso', 'Data' => $adm], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false, 'message' => 'Administrador não encontrado'], 404);
        }

        $adm->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Administrador desativado com sucesso'], 200);
    }
}

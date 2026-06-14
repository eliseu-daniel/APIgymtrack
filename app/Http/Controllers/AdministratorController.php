<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdministratorRequest;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index()
    {
        return response()->json(['status' => true, 'AdministratorsData' => Administrator::all()], 200);
    }

    public function store(CreateAdministratorRequest $request)
    {
        $validator = $request->validated();
        $validator['password'] = Hash::make($request->password);

        $adm = Administrator::create($validator);

        return response()->json(['status' => true, 'message' => 'Administrador criado com sucesso', 'Data' => $adm], 201);
    }

    public function show(string $id)
    {
        $adm = Administrator::find($id);
        if (!$adm) {
            return response()->json(['status' => false, 'message' => 'Administrador não encontrado'], 404);
        }
        return response()->json(['status' => true, 'Data' => $adm], 200);
    }

    public function update(CreateAdministratorRequest $request, string $id)
    {
        $validator = $request->validated();

        if ($request->filled('password')) {
            $validator['password'] = Hash::make($request->password);
        }

        $adm = Administrator::where('id', $id)->update($validator);

        return response()->json(['status' => true, 'message' => 'Administrador atualizado com sucesso', 'Data' => $adm], 200);
    }

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

<?php

namespace App\Http\Controllers;

use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EducatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $educator = Educator::all();
        return response()->json(['status' => true, "data"=> $educator], 200);
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $educator = Educator::select('name', 'email', 'phone', 'is_active')->where('id', $id)->first();
        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }
        return response()->json(['status' => true, 'educatorData' => $educator], 200);
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
        $educator = Educator::find($id);
        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:educators,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'password' => 'sometimes|required|string|min:6',
            'is_active' => 'sometimes|required|boolean',
        ]);

        $educator->update($request->only(['name', 'email', 'phone', 'password' => Hash::make($request->password),'is_active']));

        $educatorUpdated = Educator::select('name', 'email', 'phone', 'is_active')->where('id', $id)->first();

        return response()->json(['status' => true, 'message' => 'Educador atualizado com sucesso.', 'educatorData' => $educatorUpdated], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $educator = Educator::find($id);
        if (!$educator) {
            return response()->json(['status' => false, 'message' => 'Educador não encontrado.'], 404);
        }

        $educator->update(['is_active' => false]);

        return response()->json(['status' => true, 'message' => 'Educador desativado com sucesso.', 'data:' => $educator], 200);
    }
}

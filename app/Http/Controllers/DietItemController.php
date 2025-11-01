<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietItemRequest;
use App\Models\DietItem;
use Illuminate\Http\Request;

class DietItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['satus' => true, 'message' => DietItem::all()], 200);
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
    public function store(CreateDietItemRequest $request)
    {
        $validator = $request->validated();
        $dietItem = DietItem::create($validator);
        return response()->json(['status' => true, 'message' => 'Item de dieta criado com sucesso.', 'data' => $dietItem], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateDietItemRequest $request, string $id)
    {
        $Item = DietItem::find($id);
        if (!$Item) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }
        $validator = $request->validated();

        $dietItem = DietItem::where('id', $id)->update($validator);
        return response()->json(['status' => true, 'message' => 'Item de dieta atualizado com sucesso.', 'data' => $dietItem], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Item = DietItem::find($id);
        if (!$Item) {
            return response()->json(['status' => false, 'message' => 'Item de dieta não encontrado.'], 404);
        }
        $DietItem = DietItem::where('id', $id)->update('is_active', false);
        return response()->json(['status' => true, 'message' => 'Item de dieta desativado com sucesso.'], 200);
    }
}

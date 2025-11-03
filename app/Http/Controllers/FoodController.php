<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFoodRequest;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['status' => 'success', 'message' => Food::all()], 200);
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
    public function store(CreateFoodRequest $request)
    {
        $foodValidated = $request->validated();
        $food = Food::create($foodValidated);
        return response()->json(['status' => true, 'message' => 'Comida criada com sucesso!', 'foodData' => $food], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        return response()->json(['status' => true, 'message' => $food], 200);
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
    public function update(CreateFoodRequest $request, string $id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        $foodValidated = $request->validated();
        $food = Food::where('id', $id)->update($foodValidated);
        return response()->json(['status' => true, 'message' => 'Comida atualizada com sucesso!', 'foodData' => $food], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        Food::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Comida deletada com sucesso!'], 200);
    }
}

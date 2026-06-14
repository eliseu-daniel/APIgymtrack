<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFoodRequest;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Cache::remember('foods:all', 86400, function () {
            return Food::all();
        });

        return response()->json(['status' => 'success', 'message' => $foods], 200);
    }

    public function create()
    {
        //
    }

    public function store(CreateFoodRequest $request)
    {
        $foodValidated = $request->validated();
        $food = Food::create($foodValidated);
        Cache::forget('foods:all');
        return response()->json(['status' => true, 'message' => 'Comida criada com sucesso!', 'foodData' => $food], 201);
    }

    public function show(string $id)
    {
        $food = Cache::remember("foods:{$id}", 86400, function () use ($id) {
            return Food::find($id);
        });

        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        return response()->json(['status' => true, 'message' => $food], 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CreateFoodRequest $request, string $id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        $foodValidated = $request->validated();
        Food::where('id', $id)->update($foodValidated);
        Cache::forget('foods:all');
        Cache::forget("foods:{$id}");
        return response()->json(['status' => true, 'message' => 'Comida atualizada com sucesso!'], 200);
    }

    public function destroy(string $id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['status' => false, 'message' => 'Comida não encontrada!'], 404);
        }
        Food::where('id', $id)->delete();
        Cache::forget('foods:all');
        Cache::forget("foods:{$id}");
        return response()->json(['status' => true, 'message' => 'Comida deletada com sucesso!'], 200);
    }
}

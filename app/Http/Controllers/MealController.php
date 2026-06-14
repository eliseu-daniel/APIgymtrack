<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MealController extends Controller
{
    public function index()
    {
        $meals = Cache::remember('meals:all', 86400, function () {
            return Meal::all();
        });

        return response()->json(['staus' => true, 'mealData:' => $meals], 200);
    }

    public function create()
    {
        //
    }

    public function store(CreateMealRequest $request)
    {
        $mealValidated = $request->validated();
        $meal = Meal::create($mealValidated);
        Cache::forget('meals:all');
        return response()->json(['status' => true, 'message:' => 'Refeição criada com sucesso', 'mealData' => $meal], 201);
    }

    public function show(string $id)
    {
        $meal = Cache::remember("meals:{$id}", 86400, function () use ($id) {
            return Meal::find($id);
        });

        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }
        return response()->json(['status' => true, 'mealData:' => $meal], 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CreateMealRequest $request, string $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }

        $mealValidated = $request->validated();
        Meal::where('id', $id)->update($mealValidated);
        Cache::forget('meals:all');
        Cache::forget("meals:{$id}");
        return response()->json(['status' => true, 'message:' => 'Refeição atualizada com sucesso'], 200);
    }

    public function destroy(string $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }

        Meal::where('id', $id)->delete();
        Cache::forget('meals:all');
        Cache::forget("meals:{$id}");
        return response()->json(['status' => true, 'message:' => 'Refeição deletada com sucesso'], 200);
    }
}

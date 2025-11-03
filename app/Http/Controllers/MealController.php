<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['staus' => true, 'mealData:' => Meal::all()], 200);
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
    public function store(CreateMealRequest $request)
    {
        $mealValidated = $request->validated();
        $meal = Meal::create($mealValidated);
        return response()->json(['status' => true, 'message:' => 'Refeição criada com sucesso', 'mealData' => $meal], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }
        return response()->json(['status' => true, 'mealData:' => $meal], 200);
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
    public function update(CreateMealRequest $request, string $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }

        $mealValidated = $request->validated();
        $meal = Meal::where('id', $id)->update($mealValidated);
        return response()->json(['status' => true, 'message:' => 'Refeição atualizada com sucesso', 'mealData' => $meal], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => false, 'message:' => 'Refeição não encontrada'], 404);
        }

        Meal::where('id', $id)->delete();
        return response()->json(['status' => true, 'message:' => 'Refeição deletada com sucesso'], 200);
    }
}

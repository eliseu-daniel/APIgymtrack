<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietRequest;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $diet = Diet::all();

        return response()->json(['dietAll' => $diet], 200);
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
    public function store(CreateDietRequest $request)
    {
        $request->validated();
        $diet = Diet::create();
        return response()->json(['status' => true, 'message' => 'Dieta criada com sucesso', 'data' => $diet], 201);
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
    public function edit(string $id)
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

    public function finishDiet(Request $request)
    {
        $dateInit = $request->start_date;
        $dateFinish = $dateInit + 30;

        return $dateFinish;
    }
}

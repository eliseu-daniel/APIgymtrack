<?php

namespace App\Http\Controllers;

use App\Models\Anthropometry;
use Illuminate\Http\Request;

class AnthropometryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['satus' => true, 'data' => Anthropometry::all()], 200);
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
        $anthopometry = $request->validate([
            'patient_id'                => 'request|patients,id',
            'weights_initial'           => 'required|decimal:0,2',
            'height'                    => 'required|decimal:0,2',
            'body_fat'                  => 'required|decimal:0,2',
            'body_muscle'               => 'required|decimal:0,2',
            'physical_activity_level'   => 'required|in:light,moderate,vigorous',
            'TMB'                       => 'required|integer',
            'GET'                       => 'required|integer',
            'lesions'                   => 'nullable|string',
        ]);
        $anthopometry = Anthropometry::create($anthopometry);
        return response()->json(['status' => true, 'data' => $anthopometry], 201);
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
        $anthopometry = Anthropometry::find($id);
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Anthropometry not found'], 404);
        }

        $data = $request->validate([
            'patient_id'                => 'request|patients,id',
            'weights_initial'           => 'sometimes|decimal:0,2',
            'height'                    => 'sometimes|decimal:0,2',
            'body_fat'                  => 'sometimes|decimal:0,2',
            'body_muscle'               => 'sometimes|decimal:0,2',
            'physical_activity_level'   => 'sometimes|in:light,moderate,vigorous',
            'TMB'                       => 'sometimes|integer',
            'GET'                       => 'sometimes|integer',
            'lesions'                   => 'nullable|string',
        ]);

        $anthopometry->update($data);
        return response()->json(['status' => true, 'data' => $anthopometry], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anthopometry = Anthropometry::find($id);
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }

        $anthopometry->update(['is_active' => false]);
        return response()->json(['status' => true, 'message' => 'Antropometria desativada com sucesso'], 200);
    }
}

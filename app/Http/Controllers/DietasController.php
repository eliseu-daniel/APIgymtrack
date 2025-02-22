<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dietas;

class DietasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Dietas::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPaciente' => 'required|int',
            'idAntropometria' => 'required|int',
            'inicioDieta' => 'required|date',
            'horarioRefeicao' => 'required|string|max:6',
            'tipoDieta' => 'nullable|string|max:50',
            'pesoAtual' => 'nullable|numeric'
        ]);

        $diet = Dietas::create($validated);

        return response()->json(['message' => 'Dieta criada com sucesso!.', 'data' => $diet], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diet = Dietas::where('idDieta', $id)->first();

        if (!$diet) {
            return response()->json(['mesasge' => 'Dieta não encontrada'], 404);
        }

        return response()->json(['data' => $diet], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $diet = Dietas::where('idDieta', $id)->first();

        if (!$diet) {
            return response()->json(['mesasge' => 'Dieta não encontrada'], 404);
        }

        $validated = $request->validate([
            'idPaciente' => 'required|int',
            'idAntropometria' => 'required|int',
            'inicioDieta' => 'required|date',
            'horarioRefeicao' => 'required|string|max:6',
            'tipoDieta' => 'nullable|string|max:50',
            'pesoAtual' => 'nullable|numeric'
        ]);

        $diet->update($validated);
        return response()->json(['message' => 'Dieta atualizada com sucesso!.', 'data' => $diet], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diet = Dietas::where('idDieta', $id)->first();

        if (!$diet) {
            return response()->json(['mesasge' => 'Dieta não encontrada'], 404);
        }

        $diet->delete($id);
        return response()->json(['message' => 'Dieta deletada com sucesso!.'], 200);
    }
}

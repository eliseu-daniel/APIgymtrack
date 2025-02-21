<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Calendario;

class CalendarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Calendario::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPaciente' => 'required|int',
            'prazoPlanoCliente' => 'required|string|max:50',
            'tipoPagamentoCliente' => 'required|string|max:50'
        ]);

        $calendar = Calendario::create($validated);

        return response()->json(['message' => 'Calendário criado com sucesso.', 'data' => $calendar], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calendar = Calendario::where('idCalendario', $id)->first();

        if (!$calendar) {
            return response()->json(['error' => 'Calendário não existe.'], 404);
        }

        return response()->json($calendar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $calendar = Calendario::where('idCalendario', $id)->first();

        if (!$calendar) {
            return response()->json(['error' => 'Calendário não existe.'], 404);
        }

        $validated = $request->validate([
            'idPaciente' => 'required|int',
            'prazoPlanoCliente' => 'required|string|max:50',
            'tipoPagamentoCliente' => 'required|string|max:50'
        ]);

        $calendar->update($validated);

        return response()->json(['message' => 'Calendario atualizado com sucesso.', 'data' => $validated], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calendar = Calendario::where('idCalendario', $id)->first();

        if (!$calendar) {
            return response()->json(['error' => 'Calendário não existe.'], 404);
        }

        $calendar->delete($validated);

        return response()->json(['message' => 'Calendario apagado com sucesso.'], 200);
    }
}

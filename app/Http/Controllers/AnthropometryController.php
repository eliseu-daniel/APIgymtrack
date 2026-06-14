<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnthropometryRequest;
use App\Models\Anthropometry;
use Illuminate\Http\Request;

class AnthropometryController extends Controller
{
    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        return response()->json([
            'satus' => true,
            'data' => Anthropometry::select(
                'anthropometries.id as anthropometry_id',
                'anthropometries.*',
                'patients.name',
            )
                ->join('patients', 'patients.id', '=', 'anthropometries.patient_id')
                ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
                ->where('patient_registrations.educator_id', $idEducator)
                ->paginate($perPage)
        ], 200);
    }

    public function store(CreateAnthropometryRequest $request)
    {
        $validator = $request->validated();
        $anthopometry = Anthropometry::create($validator);
        return response()->json(['status' => true, 'message' => 'Antropometria criada com sucesso', 'data' => $anthopometry], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;

        $anthopometry = Anthropometry::select('patients.name', 'anthropometries.*')
            ->join('patients', 'patients.id', '=', 'anthropometries.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('anthropometries.id', $id)
            ->where('patient_registrations.educator_id', $idEducator)
            ->first();

        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Antropometria não encontrada'], 404);
        }

        return response()->json(['status' => true, 'data' => $anthopometry], 200);
    }

    public function update(CreateAnthropometryRequest $request, string $id)
    {
        $anthopometry = Anthropometry::find($id);
        if (!$anthopometry) {
            return response()->json(['status' => false, 'message' => 'Anthropometry not found'], 404);
        }

        $validator = $request->validated();
        Anthropometry::where('id', $id)->update($validator);
        return response()->json(['status' => true, 'message' => 'Antropometria atualizada com sucesso', 'data' => $validator], 200);
    }

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

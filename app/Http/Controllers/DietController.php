<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDietRequest;
use App\Services\DietService;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function __construct(
        private DietService $dietService
    ) {}

    public function index(Request $request)
    {
        $idEducator = $request->user()->id;
        $perPage = (int) $request->input('per_page', 15);

        return response()->json([
            'diets' => $this->dietService->getDietsForEducator($idEducator, $perPage)
        ], 200);
    }

    public function store(CreateDietRequest $request)
    {
        $diet = $this->dietService->createDiet($request->validated());
        return response()->json(['status' => true, 'message' => 'Dieta criada com sucesso', 'data' => $diet], 201);
    }

    public function show(string $id)
    {
        $idEducator = request()->user()->id;
        $diet = $this->dietService->getDietForEducator($idEducator, (int) $id);

        if (!$diet) {
            return response()->json(['status' => false, 'message' => 'Dieta não encontrada'], 404);
        }

        return response()->json(['status' => true, 'diet' => $diet], 200);
    }

    public function update(CreateDietRequest $request, string $id)
    {
        $this->dietService->updateDiet((int) $id, $request->validated());
        return response()->json(['status' => true, 'message' => 'Dieta atualizada com sucesso', 'data' => $request->validated()], 200);
    }

    public function destroy(string $id)
    {
        $diet = $this->dietService->finalizeDiet((int) $id);
        if (!$diet) {
            return response()->json(['status' => false, 'message' => 'Dieta não encontrada'], 404);
        }
        return response()->json(['status' => true, 'message' => 'Dieta finalizada com sucesso'], 200);
    }

    public function getForPacientDiets()
    {
        $idPatient = auth('patient')->id();
        return response()->json(['diets' => $this->dietService->getDietsForPatient($idPatient)], 200);
    }
}

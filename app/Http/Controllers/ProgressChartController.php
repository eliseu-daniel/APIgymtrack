<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProgressChartController extends Controller
{
    public function __construct(
        private PatientService $patientService,
        private ProgressService $progressService
    ) {}

    public function index()
    {
        return response()->json(['message' => 'ProgressChartController index']);
    }

    public function patients()
    {
        $idEducator = request()->user()->id;

        $registeredPatientIds = $this->patientService->getRegisteredPatientIds($idEducator);

        if (empty($registeredPatientIds)) {
            return response()->json([]);
        }

        $patients = \App\Models\Patient::select('id', 'name')
            ->whereIn('id', $registeredPatientIds)
            ->where(function ($q) {
                if (Schema::hasColumn('patients', 'is_active')) {
                    $q->where('is_active', 1);
                }
            })
            ->orderBy('name')
            ->get();

        return response()->json($patients);
    }

    public function reports(Request $request)
    {
        $patientId = $request->input('patient_id');
        if (empty($patientId)) {
            return response()->json(['error' => 'patient_id is required'], 422);
        }

        $limit = (int) $request->input('limit', 12);
        $response = $this->progressService->getPatientProgress((int) $patientId, $limit);

        $type = $request->input('type');
        if ($type === 'diet') {
            return response()->json($response['diet']);
        }
        if ($type === 'workout') {
            return response()->json($response['workout']);
        }

        return response()->json($response);
    }
}

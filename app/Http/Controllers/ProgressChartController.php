<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Models\PatientWeight;
use App\Models\Diet;
use App\Models\Anthropometry;
use App\Models\Workout;
use App\Models\WorkoutItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ProgressChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a simple index message or could be used to return default data
        return response()->json(['message' => 'ProgressChartController index']);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['id' => $id]);
    }

    /**
     * Return list of patients (id and name) used by the front-end select.
     */
    public function patients()
    {
        $idEducator = request()->user()->id;

        $registeredPatientIds = PatientRegistration::where('educator_id', $idEducator)
            ->pluck('patient_id')
            ->unique()
            ->toArray();

        if (empty($registeredPatientIds)) {
            return response()->json([]);
        }

        $patients = Patient::select('id', 'name')
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

    /**
     * Return report data for a patient. Accepts `patient_id` and optional `type` (diet|workout).
     * If `type` is omitted, returns both diet and workout shapes.
     */
    public function reports(Request $request)
    {
        $patientId = $request->input('patient_id');
        if (empty($patientId)) {
            return response()->json(['error' => 'patient_id is required'], 422);
        }

        $limit = (int) $request->input('limit', 12);

        // Weight series from PatientWeight
        $weights = PatientWeight::where('patient_id', $patientId)
            ->orderBy('current_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($w) {
                $d = Carbon::parse($w->current_date)->format('d/m');
                return ['date' => $d, 'value' => (float) $w->weight];
            })
            ->values();

        // Diet calories series from Diet entries
        $dietCalories = Diet::where('patient_id', $patientId)
            ->whereNotNull('calories')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($d) {
                $date = $d->start_date ? Carbon::parse($d->start_date)->format('d/m') : null;
                return ['date' => $date, 'value' => $d->calories ? (float) $d->calories : 0];
            })
            ->values();

        // TMB and bodyFat from Anthropometry entries (if multiple, use created_at ordering)
        $anthro = Anthropometry::where('patient_id', $patientId)
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($a) {
                $date = $a->updated_at ?? $a->created_at ?? null;
                $date = $date ? Carbon::parse($date)->format('d/m') : null;
                return [
                    'date' => $date,
                    'tmb' => isset($a->TMB) ? (float) $a->TMB : null,
                    'bodyFat' => isset($a->body_fat) ? (float) $a->body_fat : null,
                ];
            })
            ->values();

        // Build tmb and bodyFat series aligned to dates if possible
        $tmbSeries = $anthro->map(function ($a) {
            return ['date' => $a['date'], 'value' => $a['tmb'] ?? null];
        })->filter(function ($i) {
            return $i['date'] !== null && $i['value'] !== null;
        })->values();

        $bodyFatFromAnthro = $anthro->map(function ($a) {
            return ['date' => $a['date'], 'value' => $a['bodyFat'] ?? null];
        })->filter(function ($i) {
            return $i['date'] !== null && $i['value'] !== null;
        })->values();

        // Workout aggregates: group by workout start_date and sum loads & repetitions
        $workouts = Workout::where('patient_id', $patientId)
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();

        $loads = collect();
        $reps = collect();
        foreach ($workouts as $w) {
            $items = WorkoutItem::where('workout_id', $w->id)->get();
            if ($items->isEmpty()) {
                continue;
            }
            $date = $w->start_date ? Carbon::parse($w->start_date)->format('d/m') : null;
            $sumLoads = $items->sum(function ($it) {
                return (float) ($it->weight_load ?? 0);
            });
            $sumReps = $items->sum(function ($it) {
                return (float) ($it->repetitions ?? 0);
            });

            if ($date) {
                $loads->push(['date' => $date, 'value' => $sumLoads]);
                $reps->push(['date' => $date, 'value' => $sumReps]);
            }
        }

        // If workout weights not found, fallback to patient weight series
        $workoutWeight = $weights;

        $response = [
            'diet' => [
                'weight' => $weights,
                'calories' => $dietCalories,
                'tmb' => $tmbSeries,
                'bodyFat' => $bodyFatFromAnthro,
            ],
            'workout' => [
                'weight' => $workoutWeight,
                'loads' => $loads->values(),
                'repetitions' => $reps->values(),
                'bodyFat' => $bodyFatFromAnthro,
            ],
        ];

        $type = $request->input('type');
        if ($type === 'diet') {
            return response()->json($response['diet']);
        }
        if ($type === 'workout') {
            return response()->json($response['workout']);
        }

        return response()->json($response);
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
}

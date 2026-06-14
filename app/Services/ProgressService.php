<?php

namespace App\Services;

use App\Models\PatientWeight;
use App\Models\Diet;
use App\Models\Anthropometry;
use App\Models\Workout;
use App\Models\WorkoutItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProgressService
{
    public function getPatientProgress(int $patientId, int $limit = 12): array
    {
        $weights = $this->getWeightSeries($patientId, $limit);
        $dietCalories = $this->getDietCaloriesSeries($patientId, $limit);
        $anthro = $this->getAnthropometrySeries($patientId, $limit);
        $workoutAggregates = $this->getWorkoutAggregates($patientId, $limit);

        $tmbSeries = $anthro->map(function ($a) {
            return ['date' => $a['date'], 'value' => $a['tmb'] ?? null];
        })->filter(fn ($i) => $i['date'] !== null && $i['value'] !== null)->values();

        $bodyFatFromAnthro = $anthro->map(function ($a) {
            return ['date' => $a['date'], 'value' => $a['bodyFat'] ?? null];
        })->filter(fn ($i) => $i['date'] !== null && $i['value'] !== null)->values();

        return [
            'diet' => [
                'weight' => $weights,
                'calories' => $dietCalories,
                'tmb' => $tmbSeries,
                'bodyFat' => $bodyFatFromAnthro,
            ],
            'workout' => [
                'weight' => $weights,
                'loads' => $workoutAggregates['loads'],
                'repetitions' => $workoutAggregates['reps'],
                'bodyFat' => $bodyFatFromAnthro,
            ],
        ];
    }

    private function getWeightSeries(int $patientId, int $limit): Collection
    {
        return PatientWeight::where('patient_id', $patientId)
            ->orderBy('current_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($w) {
                return [
                    'date' => Carbon::parse($w->current_date)->format('d/m'),
                    'value' => (float) $w->weight,
                ];
            })
            ->values();
    }

    private function getDietCaloriesSeries(int $patientId, int $limit): Collection
    {
        return Diet::where('patient_id', $patientId)
            ->whereNotNull('calories')
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($d) {
                return [
                    'date' => $d->start_date ? Carbon::parse($d->start_date)->format('d/m') : null,
                    'value' => $d->calories ? (float) $d->calories : 0,
                ];
            })
            ->values();
    }

    private function getAnthropometrySeries(int $patientId, int $limit): Collection
    {
        return Anthropometry::where('patient_id', $patientId)
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($a) {
                $date = $a->updated_at ?? $a->created_at ?? null;
                return [
                    'date' => $date ? Carbon::parse($date)->format('d/m') : null,
                    'tmb' => isset($a->TMB) ? (float) $a->TMB : null,
                    'bodyFat' => isset($a->body_fat) ? (float) $a->body_fat : null,
                ];
            })
            ->values();
    }

    private function getWorkoutAggregates(int $patientId, int $limit): array
    {
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
            $sumLoads = $items->sum(fn ($it) => (float) ($it->weight_load ?? 0));
            $sumReps = $items->sum(fn ($it) => (float) ($it->repetitions ?? 0));

            if ($date) {
                $loads->push(['date' => $date, 'value' => $sumLoads]);
                $reps->push(['date' => $date, 'value' => $sumReps]);
            }
        }

        return [
            'loads' => $loads->values(),
            'reps' => $reps->values(),
        ];
    }
}

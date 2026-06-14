<?php

namespace App\Services;

use App\Models\Diet;
use App\Models\DietItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DietService
{
    public function getDietsForEducator(int $educatorId, int $perPage = 15): LengthAwarePaginator
    {
        return Diet::select('patients.name as patient_name', 'diets.id as diet_id', 'diets.*')
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->orderBy('diets.start_date', 'desc')
            ->paginate($perPage);
    }

    public function getDietForEducator(int $educatorId, int $dietId): ?Diet
    {
        return Diet::select(['diets.*', 'patients.name as patient_name'])
            ->join('patients', 'diets.patient_id', '=', 'patients.id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('diets.id', $dietId)
            ->first();
    }

    public function createDiet(array $data): Diet
    {
        return Diet::create($data);
    }

    public function updateDiet(int $id, array $data): bool
    {
        return (bool) Diet::where('id', $id)->update($data);
    }

    public function finalizeDiet(int $id): ?Diet
    {
        $diet = Diet::find($id);
        if (!$diet) {
            return null;
        }
        $diet->update(['finalized_at' => now()]);
        return $diet;
    }

    public function getDietsForPatient(int $patientId): Collection
    {
        return Diet::select('diets.id as diet_id', 'diets.*')
            ->where('diets.patient_id', $patientId)
            ->orderBy('diets.start_date', 'desc')
            ->get();
    }

    public function getDietItems(int $educatorId, int $perPage = 15): LengthAwarePaginator
    {
        return DietItem::select(
            'diet_items.id as diet_item_id',
            'diets.id as diet_id',
            'food.id as food_id',
            'patients.name',
            'food.name as food_name',
            'diet_items.*',
            'meals.id as meal_id',
            'meals.name as meal_name',
        )
            ->join('diets', 'diets.id', '=', 'diet_items.diet_id')
            ->join('patients', 'patients.id', '=', 'diets.patient_id')
            ->join('patient_registrations', 'patient_registrations.patient_id', '=', 'patients.id')
            ->join('food', 'food.id', '=', 'diet_items.food_id')
            ->join('meals', 'meals.id', '=', 'diet_items.meals_id')
            ->where('patient_registrations.educator_id', $educatorId)
            ->where('diet_items.is_active', true)
            ->paginate($perPage);
    }
}

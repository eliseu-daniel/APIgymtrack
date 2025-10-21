<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDietRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id'        => 'required|exists:patients,id',
            'meals_id'          => 'required|exists:meals,id',
            'meal_time'         => 'required',
            'diet_type'         => 'nullable|string',
            'goal_weight'       => 'nullable|string',
            'objective'         => 'nullable|string',
            'calories'          => 'required|integer',
            'proteins'          => 'required|integer',
            'carbohydrates'     => 'required|integer',
            'fats'              => 'required|integer',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date',
            'finalized_at'      => 'nullable|date'
        ];
    }

    public function message(): array
    {
        return [
            'patient_id' => 'O campo paciente é obrigatório e deve existir na tabela pacientes.',
            'meals_id' => 'O campo refeição é obrigatório e deve existir na tabela refeições.',
            'meal_time' => 'O campo horário da refeição é obrigatório.',
            'calories' => 'O campo calorias é obrigatório e deve ser um número inteiro.',
            'proteins' => 'O campo proteínas é obrigatório e deve ser um número inteiro.',
            'carbohydrates' => 'O campo carboidratos é obrigatório e deve ser um número inteiro.',
            'fats' => 'O campo gorduras é obrigatório e deve ser um número inteiro.',
            'start_date' => 'O campo data de início é obrigatório e deve ser uma data válida.',
            'end_date' => 'O campo data de término é obrigatório e deve ser uma data válida.',
        ];
    }
}

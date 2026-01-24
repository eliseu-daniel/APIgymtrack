<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkoutRequest extends FormRequest
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
            'workout_type_id' => 'nullable|integer|exists:workout_types,id',
            'patient_id' => 'required|integer|exists:patients,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'finalized_at' => 'nullable|date|after_or_equal:end_date',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Campo paciente é obrigatório.',
            'patient_id.integer' => 'ID do paciente tem que ser número.',
            'patient_id.exists' => 'O paciente não existe.',
            'start_date.required' => 'Data de início é obrigatória.',
            'start_date.date' => 'Data de início não é válida.',
            'end_date.date' => 'Data de fim não é válida.',
            'end_date.after_or_equal' => 'A data final é menor que a data de início.',
            'finalized_at.date' => 'A data de finalização não é válida.',
            'finalized_at.after_or_equal' => 'A data de finalização tem que ser maior ou igual a de fim.',
        ];
    }
}

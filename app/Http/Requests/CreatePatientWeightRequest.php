<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientWeightRequest extends FormRequest
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
            "weight" => ["required", "numeric"],
            "patient_id" => ["required", "integer", "exists:patients,id"],
            "current_date" => ["required", "date"],
        ];
    }

    public function messages(): array
    {
        return [
            "weight.required" => "O campo peso é obrigatório.",
            "weight.numeric" => "O campo peso deve ser um número válido.",
            "patient_id.required" => "O campo ID do paciente é obrigatório.",
            "patient_id.integer" => "O campo ID do paciente deve ser um número inteiro.",
            "patient_id.exists" => "O paciente com o ID fornecido não existe.",
            "current_date.required" => "O campo data atual é obrigatório.",
            "current_date.date" => "O campo data atual deve ser uma data válida.",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnthropometryRequest extends FormRequest
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
            'patient_id'                => 'request|patients,id',
            'weights_initial'           => 'required|decimal:0,2',
            'height'                    => 'required|decimal:0,2',
            'body_fat'                  => 'required|decimal:0,2',
            'body_muscle'               => 'required|decimal:0,2',
            'physical_activity_level'   => 'required|in:light,moderate,vigorous',
            'TMB'                       => 'required|integer',
            'GET'                       => 'required|integer',
            'lesions'                   => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.request' => 'O campo paciente é obrigatório.',
            'weights_initial.required' => 'O campo peso inicial é obrigatório.',
            'height.required' => 'O campo altura é obrigatório.',
            'body_fat.required' => 'O campo gordura corporal é obrigatório.',
            'body_muscle.required' => 'O campo massa muscular é obrigatório.',
            'physical_activity_level.required' => 'O campo nível de atividade física é obrigatório.',
            'TMB.required' => 'O campo TMB é obrigatório.',
            'GET.required' => 'O campo GET é obrigatório.',
        ];
    }
}

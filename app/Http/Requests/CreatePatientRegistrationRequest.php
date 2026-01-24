<?php

namespace App\Http\Requests;

use App\Services\DateServices;
use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $dateServices = new DateServices();

        if ($this->has('start_date') && $this->has('plan_description')) {
            $startDate = $this->input('start_date');
            if (preg_match('/^\d{2}[\/-]\d{2}[\/-]\d{4}$/', $startDate)) {
                $startDate = str_replace('-', '/', $startDate);
                $startDate = $dateServices->toDatabaseFormat($startDate);
            }

            try {
                $endDate = DateServices::generatePlan($startDate, $this->input('plan_description'));
                $this->merge([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            } catch (\InvalidArgumentException $e) {
                $this->merge(['end_date' => null]);
                $this->getValidatorInstance()->errors()->add('plan_description', $e->getMessage());
            }
        }
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
            'educator_id'       => 'required|exists:educators,id',
            'plan_description'  => 'required|in:monthly,quarterly,semiannual',
            'start_date'        => 'required|date_format:Y-m-d',
            'end_date'          => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'finalized_at'       => 'sometimes|date_format:Y-m-d|after_or_equal:end_date',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required'       => 'O campo paciente é obrigatório.',
            'patient_id.exists'         => 'O paciente selecionado não existe.',
            'educator_id.required'      => 'O campo educador é obrigatório.',
            'educator_id.exists'        => 'O educador selecionado não existe.',
            'plan_description.required' => 'O campo descrição do plano é obrigatório.',
            'plan_description.in'       => 'A descrição do plano deve ser mensal, trimestral ou semestral.',
            'start_date.required'       => 'O campo data de início é obrigatório.',
            'start_date.date'           => 'O campo data de início deve ser uma data válida.',
            'end_date.required'         => 'O campo data de término é obrigatório.',
            'end_date.date'             => 'O campo data de término deve ser uma data válida.',
            'end_date.after_or_equal'   => 'A data de término deve ser igual ou posterior à data de início.',
            'finalized_at.date'         => 'O campo data de finalização deve ser uma data válida.',
            'finalized_at.after_or_equal' => 'A data de finalização deve ser igual ou posterior à data de término.',
        ];
    }
}

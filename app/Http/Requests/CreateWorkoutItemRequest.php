<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkoutItemRequest extends FormRequest
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
            'workout_id' => 'required|integer|exists:workouts,id',
            'exercise_id' => 'required|integer|exists:exercises,id',
            'day_of_week' => 'required|integer|min:1|max:7',
            'series' => 'nullable|integer|min:1',
            'repetitions' => 'nullable|integer|min:1',
            'weight_load' => 'nullable|numeric|min:0',
            'duration_time' => 'nullable|integer|min:0',
            'rest_time' => 'nullable|integer|min:0',
            'send_notification' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'workout_id.required' => 'Treino é obrigatório.',
            'workout_id.integer' => 'The workout ID must be an integer.',
            'workout_id.exists' => 'O treino não existe.',
            'exercise_id.required' => 'Exercício é obrigatorio.',
            'exercise_id.integer' => 'The exercise ID must be an integer.',
            'exercise_id.exists' => 'O exercício não existe.',
            'day_of_week.required' => 'Dia da semana é obrigatório.',
            'day_of_week.integer' => 'The day of the week must be an integer.',
            'day_of_week.min' => 'É obrigatório escolher pelo menos 1 dia da semana.',
            'day_of_week.max' => 'Não é possivel escolher mais que 7 dias da semana.',
        ];
    }
}

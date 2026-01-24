<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExerciseRequest extends FormRequest
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
            'muscle_group_id' => 'nullable|exists:muscle_groups,id',
            'exercise' => 'required|string|max:255',
            'link_exercise' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'muscle_group_id' => 'Grupo muscular selecionado não existe.',
            'exercise' => 'Nome do exercicio é obrigatório.',
            'exercise' => 'Nome do exercicio não pode passar 255 caracteres.',
            'link_exercise' => 'Obrigatório um link de execução para o exercicio.',
        ];
    }
}

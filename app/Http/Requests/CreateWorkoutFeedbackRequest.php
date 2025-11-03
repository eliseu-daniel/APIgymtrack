<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkoutFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'workout_item_id' => 'required|integer|exists:workout_items,id',
            'comment' => 'required|string|max:1000',
            'send_notification' => 'required|boolean',
        ];
    }

    function messages(): array
    {
        return [
            'workout_item_id.required' => 'O campo workout_item_id é obrigatório.',
            'workout_item_id.integer' => 'O campo workout_item_id deve ser um número inteiro.',
            'workout_item_id.exists' => 'O workout_item_id fornecido não existe.',
            'comment.required' => 'O campo comment é obrigatório.',
            'comment.string' => 'O campo comment deve ser uma string.',
            'comment.max' => 'O campo comment não pode exceder 1000 caracteres.',
            'send_notification.required' => 'O campo send_notification é obrigatório.',
            'send_notification.boolean' => 'O campo send_notification deve ser verdadeiro ou falso.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDietFeedbackRequest extends FormRequest
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
            'diet_id' => 'required|integer|exists:diets,id',
            'comment' => 'required|string|max:1000',
            'send_notification' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'diet_id.required' => 'Obrigátorio escolher uma dieta.',
            'diet_id.exists' => 'Dieta especificada não existe.',
            'comment.required' => 'O comentário é obrigatório.',
            'comment.string' => 'O comentário deve ser apenas em texto.',
            'comment.max' => 'O comentário não deve ser maior que 1000 caracteres.',
            'send_notification.required' => 'enviar notificação é obrigatório.',
            'send_notification.boolean' => 'A notificação deve ser true ou false.',
        ];
    }
}

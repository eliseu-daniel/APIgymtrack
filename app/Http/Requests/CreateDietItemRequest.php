<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDietItemRequest extends FormRequest
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
            'diet_id' => 'required|exists:diets,id',
            'food_id' => 'required|exists:food,id',
            'measure' => 'required|in:und,gr,ml,l',
            'others' => 'nullable|string',
            'send_notification' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'diet_id.required' => 'Obrigatório informar a dieta.',
            'diet_id.exists' => 'Dieta selecionada é invalida.',
            'food_id.required' => 'O alimento é obrigatório.',
            'food_id.exists' => 'Alimento selecionado inválido.',
            'measure.required' => 'Obrigatório as medidas.',
            'measure.in' => 'Unidade inválida. Valores aceitos: und, gr, ml.',
            'others.string' => 'Outros é somente texto.',
            'send_notification.boolean' => 'Enviar notificação é somente true ou false.',
            'is_active.boolean' => 'Campo ativo é somente true ou false.',
        ];
    }
}

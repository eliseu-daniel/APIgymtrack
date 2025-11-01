<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdministratorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:administrators',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'is_active' => 'sometimes|boolean',
            'is_admin' => 'sometimes|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'phone.required' => 'O campo telefone é obrigatório.',
        ];
    }
}

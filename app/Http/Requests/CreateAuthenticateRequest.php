<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAuthenticateRequest extends FormRequest
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
            'email' => 'required|email|unique:educators',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O e-mail fornecido não é válido.',
            'email.unique' => 'O e-mail já está em uso.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O nome deve conter letras.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',
            'phone.required' => 'O campo de telefone é obrigatório.',
            'phone.string' => 'O telefone deve ser uma string.',
            'phone.max' => 'O telefone não pode exceder 20 caracteres.',
        ];
    }
}

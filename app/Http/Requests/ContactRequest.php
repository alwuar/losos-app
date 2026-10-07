<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:150'],
            'phone_code' => ['required', 'string', 'max:6'],
            'phone' => ['required', 'string', 'max:25'],
            'company' => ['nullable', 'string', 'max:150'],
            'equipment' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'Escribe un correo electrónico válido.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'nombre',
            'last_name' => 'apellido',
            'email' => 'email',
            'phone' => 'teléfono',
            'company' => 'empresa',
            'equipment' => 'equipo',
        ];
    }
}

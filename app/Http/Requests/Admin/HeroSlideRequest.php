<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HeroSlideRequest extends FormRequest
{
    // Enlace interno (/productos), externo (https://…), ancla (#…), correo o teléfono
    protected const LINK = 'regex:/^(\/|#|https?:\/\/|mailto:|tel:)\S*$/';

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $creating = $this->route('slide') === null;

        return [
            'image' => [$creating ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'title' => ['required', 'string', 'max:140'],
            'text' => ['nullable', 'string', 'max:400'],
            'primary_label' => ['nullable', 'string', 'max:40', 'required_with:primary_url'],
            'primary_url' => ['nullable', 'string', 'max:255', 'required_with:primary_label', self::LINK],
            'secondary_label' => ['nullable', 'string', 'max:40', 'required_with:secondary_url'],
            'secondary_url' => ['nullable', 'string', 'max:255', 'required_with:secondary_label', self::LINK],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'image' => 'imagen',
            'title' => 'título',
            'text' => 'texto',
            'primary_label' => 'texto del botón 1',
            'primary_url' => 'enlace del botón 1',
            'secondary_label' => 'texto del botón 2',
            'secondary_url' => 'enlace del botón 2',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'primary_url.regex' => 'El enlace debe empezar con / (página del sitio) o https:// (otro sitio).',
            'secondary_url.regex' => 'El enlace debe empezar con / (página del sitio) o https:// (otro sitio).',
        ];
    }
}

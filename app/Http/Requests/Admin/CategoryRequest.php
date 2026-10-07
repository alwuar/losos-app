<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['nullable', 'alpha_dash', 'max:100', Rule::unique('categories', 'slug')->ignore($this->route('category'))],
            'label' => ['nullable', 'string', 'max:40'],
            'card_title' => ['nullable', 'string', 'max:80'],
            'summary' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'benefits' => ['nullable', 'array', 'max:6'],
            'benefits.*.text' => ['nullable', 'string', 'max:80'],
            'types' => ['nullable', 'array', 'max:20'],
            'types.*.id' => ['nullable', 'integer'],
            'types.*.name' => ['nullable', 'string', 'max:60'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'slug' => 'URL',
            'image' => 'imagen',
            'types.*.name' => 'tipo',
        ];
    }
}

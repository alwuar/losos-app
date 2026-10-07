<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ProductRequest extends FormRequest
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
        $product = $this->route('product');

        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'alpha_dash', 'max:140', Rule::unique('products', 'slug')->ignore($product)],
            'category_id' => ['required', 'exists:categories,id'],
            'product_type_id' => ['nullable', 'exists:product_types,id'],
            'brand' => ['nullable', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_published' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],

            'card_specs' => ['nullable', 'array', 'max:6'],
            'card_specs.*.label' => ['nullable', 'string', 'max:60'],
            'card_specs.*.value' => ['nullable', 'string', 'max:60'],

            'highlights' => ['nullable', 'array', 'max:8'],
            'highlights.*.label' => ['nullable', 'string', 'max:60'],
            'highlights.*.value' => ['nullable', 'string', 'max:60'],

            'features' => ['nullable', 'array', 'max:6'],
            'features.*.title' => ['nullable', 'string', 'max:80'],
            'features.*.text' => ['nullable', 'string', 'max:400'],

            'spec_groups' => ['nullable', 'array', 'max:12'],
            'spec_groups.*.title' => ['nullable', 'string', 'max:80'],
            'spec_groups.*.rows' => ['nullable', 'array', 'max:30'],
            'spec_groups.*.rows.*.label' => ['nullable', 'string', 'max:80'],
            'spec_groups.*.rows.*.value' => ['nullable', 'string', 'max:80'],

            'images' => ['nullable', 'array', 'max:12'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*.alt' => ['nullable', 'string', 'max:120'],
            'gallery.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'gallery.*.remove' => ['nullable', 'boolean'],

            'brochure' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'remove_brochure' => ['nullable', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $typeId = $this->input('product_type_id');

                if ($typeId && ! ProductType::whereKey($typeId)->where('category_id', $this->input('category_id'))->exists()) {
                    $validator->errors()->add('product_type_id', 'El tipo elegido no pertenece a la categoría.');
                }
            },
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
            'category_id' => 'categoría',
            'product_type_id' => 'tipo',
            'brand' => 'marca',
            'tagline' => 'frase corta',
            'description' => 'descripción',
            'images.*' => 'imagen',
            'brochure' => 'ficha técnica (PDF)',
        ];
    }
}

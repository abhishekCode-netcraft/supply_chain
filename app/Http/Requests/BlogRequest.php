<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'selling_price' => 'required|numeric',
            'mrp' => 'required|numeric|gte:selling_price',
            'label' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!in_array('Product', $value)) {
                        $fail('Category must contain Product Tag');
                    }
                },
            ],
            'images' => 'required|array|min:1',
            'sku' => 'required|string|max:255',
            'publication' => 'required|string|max:255',
            'author_name' => 'required|string',
            'edition' => 'required|string|max:255',
            'binding' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'pages' => 'required|string',
            'language' => 'required|string|max:255',
            'isbn_10' => 'required|string|max:255',
            'isbn_13' => 'required|string|max:255',
            'publish_year' => 'required|string|max:255',
            'weight' => 'required|string|max:255',
            'reading_age' => 'required|string|max:255',
            'country_origin' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'importer' => 'required|string|max:255',
            'packer' => 'required|string|max:255',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                Rule::unique('items', 'sku')->ignore($this->item),
            ],
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brand_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
        ];
    }

    #[\Override]
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a product name',
            'name.max' => 'The product name cannot exceed 255 characters',
            'sku.required' => 'Please enter a product sku',
            'sku.unique' => 'This product sku already exist',
            'cost_price.required' => 'Please enter a product cost price',
            'cost_price.numeric' => 'Please enter a numeric product cost price',
            'selling_price.required' => 'Please enter a product selling price',
            'selling_price.numeric' => 'Please enter a numeric product selling price',
            'quantity.required' => 'Please enter a product quantity',
            'quantity.numeric' => 'Please enter a numeric product quantity',
        ];
    }
}

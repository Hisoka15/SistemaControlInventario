<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'code_inventory' => 'required|unique:inventories,code_inventory',
            'description' => 'required|string|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'El campo producto es obligatorio.',
            'product_id.exists' => 'El producto seleccionado no existe.',
            'code_inventory.required' => 'El campo código de inventario es obligatorio.',
            'code_inventory.unique' => 'El código de inventario ya está en uso.',
            'description.required' => 'El campo descripción es obligatorio.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.min' => 'La descripción debe tener al menos :min caracteres.',
        ];
    }
}

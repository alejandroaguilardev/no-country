<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CriteriaRequest extends FormRequest
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
            'limit' => 'integer|min:1|max:100',
            'offset' => 'integer|min:0',
            'filters' => 'array',
            'filters.*.field' => 'string|min:1|max:255',
            'filters.*.value' => 'string|min:1|max:255',
            'sorts' => 'array',
            'globalFilter' => 'string|min:1|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ]));
    }

    public function messages(): array
    {
        return [
            'limit.integer' => 'El límite debe ser un número entero.',
            'limit.min' => 'El límite mínimo es 1.',
            'limit.max' => 'El límite máximo es 100.',
            'offset.integer' => 'El offset debe ser un número entero.',
            'offset.min' => 'El offset mínimo es 0.',
            'filters.array' => 'Los filtros deben ser un array.',
            'sorts.array' => 'Las ordenaciones deben ser un array.',
            'globalFilter.string' => 'El filtro global debe ser una cadena de texto.',
            'globalFilter.min' => 'El filtro global debe tener al menos 1 carácter.',
            'globalFilter.max' => 'El filtro global no puede tener más de 255 caracteres.',
        ];
    }
}

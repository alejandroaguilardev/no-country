<?php

namespace App\Http\Requests\Authorized;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAuthorizedRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'document_number' => 'required|string|min:8|max:20|unique:authorizeds,document_number',
            'phone' => 'required|string|min:10|max:15',
            'photo' => 'nullable|string|min:3|max:255',
            'tutor_id' => 'required|exists:tutors,id',
            'student_id' => 'array',
            'student_id.*' => 'required|integer|exists:students,id',
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
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.string' => 'El apellido debe ser una cadena de texto.',
            'last_name.min' => 'El apellido debe tener al menos 2 caracteres.',
            'last_name.max' => 'El apellido no puede tener más de 255 caracteres.',

            'document_number.required' => 'El número de documento es obligatorio.',
            'document_number.string' => 'El número de documento debe ser una cadena de texto.',
            'document_number.min' => 'El número de documento debe tener al menos 8 caracteres.',
            'document_number.max' => 'El número de documento no puede tener más de 20 caracteres.',
            'document_number.unique' => 'El número de documento ya está en uso.',

            'phone.required' => 'El teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser una cadena de texto.',
            'phone.min' => 'El teléfono debe tener al menos 10 caracteres.',
            'phone.max' => 'El teléfono no puede tener más de 15 caracteres.',

            'photo.string' => 'La foto debe ser una cadena de texto.',
            'photo.min' => 'La foto debe tener al menos 3 caracteres.',
            'photo.max' => 'La foto no puede tener más de 255 caracteres.',

            'tutor_id.required' => 'El tutor es obligatorio.',
            'tutor_id.exists' => 'El tutor seleccionado no es válido.',
        ];
    }
}

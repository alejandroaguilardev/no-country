<?php

namespace App\Http\Requests\Authorized;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LeaveAloneAuthorizedRequest extends FormRequest
{
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
            'student_id' => 'required|integer|exists:students,id',
            'leaveAlone' => 'required|boolean'
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'student_id' => $this->route('student_id'),
    //     ]);
    // }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ]));
    } 
}

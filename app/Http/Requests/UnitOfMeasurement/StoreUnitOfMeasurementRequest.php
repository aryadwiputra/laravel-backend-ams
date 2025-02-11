<?php

namespace App\Http\Requests\UnitOfMeasurement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUnitOfMeasurementRequest extends FormRequest
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
            "name"=> "required|string|max:255|min:1",
            "description" => "required|string",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama harus diisi.",
            "name.string"=> "Nama harus berupa string.",
            "name.max"=> "Nama tidak boleh lebih dari 255 karakter.",
            "name.min"=> "Nama minimal harus 1 karakter.",
            "description.required" => "Deskripsi harus diisi.",
            "description.string" => "Deskripsi harus berupa string.",
        ];
    }

     /**
     * Failed validation for response
     */
    
     public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
     {
         throw new HttpResponseException($this->validationError('Validation Error', $validator->errors()));
     }
}

<?php

namespace App\Http\Requests\Category;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
{
    use ApiResponse;

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
            "name"=> "required|string|max:255|min:3",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama harus diisi.",
            "name.string"=> "Nama harus berupa string.",
            "name.max"=> "Karakter nama tidak boleh lebih dari 255.",
            "name.min"=> "Karakter nama minimal harus 3.",
            "image.image" => "File harus berupa gambar.",
            "image.mimes" => "Format gambar harus jpeg, png, jpg, gif, svg.",
            "image.max" => "Ukuran gambar tidak boleh lebih dari 2MB.",
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

<?php

namespace App\Http\Requests\Company;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCompanyRequest extends FormRequest
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
            "description" => "required|string",
            "set_prefix_asset" => "required|boolean",
            "set_prefix_document_asset"=> "required|boolean",
            "set_prefix_mutation_asset" => "required|boolean",
            "set_prefix_disposal_asset" => "required|boolean",
            "logo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama harus diisi.",
            "name.string"=> "Nama harus berupa string.",
            "name.max"=> "Nama tidak boleh lebih dari 255 karakter.",
            "name.min"=> "Nama minimal harus 3 karakter.",
            "description.required" => "Deskripsi harus diisi.",
            "description.string" => "Deskripsi harus berupa string.",
            "set_prefix_asset.required" => "Set Prefix Asset harus diisi.",
            "set_prefix_document_asset.required" => "Set Prefix Document Asset harus diisi.",
            "set_prefix_mutation_asset.required"=> "Set Prefix Mutation Asset harus diisi.",
            "set_prefix_disposal_asset.required"=> "Set Prefix Disposal Asset harus diisi.",
            "logo.image" => "File harus berupa gambar.",
            "logo.mimes" => "Format gambar harus jpeg, png, jpg, gif, svg.",
            "logo.max" => "Ukuran gambar tidak boleh lebih dari 2MB.",
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

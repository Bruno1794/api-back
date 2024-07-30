<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|unique:clients',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Campo nome é obrigatorio',
            'name.unique' => 'Nome já cadastrado',
            'phone.required' => 'Campo telefone e obrigatorio',
            'address.required' => 'Campo endereço e obrigatorio',
        ];
    }
}

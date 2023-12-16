<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RealPropertyTaxRequest extends FormRequest
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
            'area_type' => 'required|string|max:255',
            'basic_property_tax' => 'required|integer',
            'special_education_fund' => 'required|integer',
            'property_owner_id' => 'required|integer',
        ];
    }
}

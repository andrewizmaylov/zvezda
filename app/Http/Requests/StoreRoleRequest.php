<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
			'name' => [
				'required',
				'max:50',
				'regex:/^[a-zA-Z\s]+$/',
				Rule::unique('roles')->ignore($this->_id),
			],
			'id' => [
				'required',
				'integer',
				'min:0',
				'max:255',
				Rule::unique('roles')->ignore($this->_id),
			],
        ];
    }
}

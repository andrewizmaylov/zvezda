<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
			'zip'              => 'nullable|string',
			'country'          => 'nullable|string',
			'city'             => 'nullable|string',
			'street_01'        => 'nullable|string',
			'street_02'        => 'nullable|string',
		];
	}
}

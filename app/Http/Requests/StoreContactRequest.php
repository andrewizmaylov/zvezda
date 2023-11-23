<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
			'first_name'  => 'nullable|max:100',
			'second_name' => 'nullable|max:100',
			'last_name'   => 'nullable|max:100',
			'phone'       => 'nullable|max:100',
			'tg'          => 'nullable|starts_with:@|max:50',
			'city'        => 'nullable|max:100',
			'social'      => 'nullable|max:100',
			'birthday'    => 'nullable|date',
		];
	}

}

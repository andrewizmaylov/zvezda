<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
			'id' => 'nullable|string|max:36',
			'email' => ['nullable','string','max:36',Rule::unique('users')->ignore($this->id)],
			'profile_photo_path' => ['nullable','string'],
			'first_name' => 'nullable|max:100',
			'second_name' => 'nullable|max:100',
			'last_name' => 'nullable|max:100',
			'birthday' => 'nullable|date',
			'tg' => 'nullable|max:100|string|starts_with:@|regex:/^@[a-zA-Z0-9_-]+$/',
			'role' => 'required',
		];
	}
}

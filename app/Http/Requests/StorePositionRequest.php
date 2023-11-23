<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
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
	        'name' => 'required|max:100',
	        'slug' => 'nullable',
	        'description' => 'nullable|string',
	        'details' => 'nullable|string',
	        'published_at' => 'nullable|date',
	        'image' => 'nullable',
        ];
    }
}

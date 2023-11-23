<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
	        'name' => 'nullable|max:255',
	        'slug' => 'nullable',
	        'description' => 'nullable|string',
	        'details' => 'nullable',
	        'published_at' => 'nullable',
	        'image' => 'nullable',
	        'date' => 'nullable',
	        'time' => 'nullable',
	        'team_a' => 'nullable|string|max:36',
	        'team_b' => 'nullable|string|max:36',
	        'stadium_id' => 'nullable|string|max:36',
        ];
    }
}

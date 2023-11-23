<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'published_at' => 'nullable',
            'details' => 'nullable',
            'image' => 'nullable',
            'date' => 'required',
            'time' => 'nullable',
            'team_a' => 'required|string|max:36',
            'team_b' => 'required|string|max:36',
            'stadium_id' => 'nullable|string|max:36',
        ];
    }
}

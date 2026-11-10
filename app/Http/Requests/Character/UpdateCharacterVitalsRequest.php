<?php

namespace App\Http\Requests\Character;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterVitalsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hit_points_current' => ['nullable', 'integer', 'min:0', 'max:50'],
            'stress_current' => ['nullable', 'integer', 'min:0', 'max:50'],
            'hope_current' => ['nullable', 'integer', 'min:0', 'max:20'],
            'armor_slots_current' => ['nullable', 'integer', 'min:0', 'max:20'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}

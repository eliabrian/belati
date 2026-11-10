<?php

namespace App\Http\Requests\Character;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'pronouns' => ['nullable', 'string', 'max:50'],
            'character_class_id' => ['required', 'exists:character_classes,id'],
            'subclass_id' => ['nullable', 'exists:subclasses,id'],
            'ancestry_id' => ['required', 'exists:ancestries,id'],
            'community_id' => ['required', 'exists:communities,id'],

            'agility' => ['required', 'integer', 'between:-3,5'],
            'strength' => ['required', 'integer', 'between:-3,5'],
            'finesse' => ['required', 'integer', 'between:-3,5'],
            'instinct' => ['required', 'integer', 'between:-3,5'],
            'presence' => ['required', 'integer', 'between:-3,5'],
            'knowledge' => ['required', 'integer', 'between:-3,5'],

            'starting_card_ids' => ['nullable', 'array', 'max:4'],
            'starting_card_ids.*' => ['exists:domain_cards,id'],

            'background' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'email' => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                //Rule::unique(User::class)->ignore($this->user()->id),
            ],
            
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['sometimes', 'nullable', 'string', 'max:2048']

        ];
    }
}
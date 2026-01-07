<?php

namespace App\Http\Requests\Profiles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = (int) $this->route('id');

        return [
            'user_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('profiles', 'user_id')->ignore($id),
            ],
            'bio' => ['sometimes', 'nullable', 'string'],
        ];
    }
}

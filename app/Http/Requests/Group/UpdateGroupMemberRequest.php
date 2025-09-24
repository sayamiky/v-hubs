<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupMemberRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id' => 'sometimes|exists:groups,id',
            'user_id' => 'sometimes|exists:users,id',
            'role' => 'sometimes|in:member,admin',
            'joined_at' => 'nullable|date_format:Y-m-d H:i:s'
        ];
    }
}

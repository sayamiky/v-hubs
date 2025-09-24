<?php

namespace App\Http\Requests\Group;

use App\Rules\RequestGroupRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequestRequest extends FormRequest
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
            'status' => ["sometimes","in:pending,approved,rejected"],
        ];
    }
}

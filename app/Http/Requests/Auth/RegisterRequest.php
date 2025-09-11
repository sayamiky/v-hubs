<?php

namespace App\Http\Requests\Auth;

use App\Dtos\Auth\RegisterDto;
use App\Http\Requests\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    protected string $dtoClass = RegisterDto::class;
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
            'role' => 'required|in:user,seller',
            'name' => 'required|string',
            'birthdate' => 'required|date',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'referral_id' => 'nullable|string'
        ];
    }
}

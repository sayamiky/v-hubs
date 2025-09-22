<?php

namespace App\Http\Requests\Timeline;

use App\Rules\LikePostRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineLikeRequest extends FormRequest
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
            'timeline_post_id' => ['required', 'string', 'exists:timeline_posts,id', new LikePostRule()],
        ];
    }
}

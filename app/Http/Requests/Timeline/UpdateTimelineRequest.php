<?php

namespace App\Http\Requests\Timeline;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimelineRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'visibility' => 'sometimes|in:public,private,friends',
            'media.*.media_type' => 'sometimes|string',
            'media.*.media_path' => 'sometimes|mimes:mp4,mpg,mpeg,avi,mov,wmv,jpeg,jpg,png|max:15000|in:image,video',
        ];
    }
}

<?php

namespace App\Http\Requests\Timeline;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private,friends',
            'group_id' => 'nullable|exists:groups,id',
            'media.*.media_type' => 'required|string',
            'media.*.media_path' => 'required|mimes:mp4,mpg,mpeg,avi,mov,wmv,jpeg,jpg,png|max:15000|in:image,video',
        ];
    }
}

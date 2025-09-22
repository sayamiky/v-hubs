<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LikePostRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Add your custom validation logic here.
        // For example, check if the user has already liked the post.
        $user = auth()->user();
        $hasLiked = $user->like()->where('timeline_post_id', $value)->exists();

        if ($hasLiked) {
            $fail('You have already liked this post.');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TimelineComment extends Model
{
    use HasUuids;

    protected $table = 'timeline_comments';
    protected $fillable = [
        'timeline_post_id',
        'user_id',
        'content',
    ];

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

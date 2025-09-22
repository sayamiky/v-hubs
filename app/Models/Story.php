<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Story extends Model
{
    use HasUuids, SoftDeletes;
    protected $table = 'stories';
    protected $fillable = [
        'user_id',
        'media_path',
        'caption',
        'visibility',
        'expires_at',
        'deleted_by'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    function scopeActive()
    {
        return $this->where('expires_at', '>', now())->where('deleted_at', null);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = 'stories';
    protected $fillable = [
        'user_id',
        'media_path',
        'caption',
        'expires_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Timeline extends Model
{
    use  HasUuids;
    
    protected $table = 'timeline_posts';
    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'description',
        'visibility',
    ];

    // Event creating to set UUID as primary key before creating the model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->hasMany(TimelineMedia::class, 'timeline_post_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(TimelineComment::class, 'timeline_post_id', 'id');
    }

    public function like()
    {
        return $this->hasMany(TimelineLike::class, 'timeline_post_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}

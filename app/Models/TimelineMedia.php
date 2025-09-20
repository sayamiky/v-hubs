<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TimelineMedia extends Model
{
    protected $table = 'timeline_medias';
    protected $fillable = [
        'timeline_post_id',
        'media_path',
        'media_type',
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

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_post_id', 'id');
    }
}

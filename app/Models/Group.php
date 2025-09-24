<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'groups';
    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'owner_id',
        'privacy',
        'deleted_by'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function member()
    {
        return $this->hasMany(GroupMember::class, 'group_id', 'id');
    }

    public function request()
    {
        return $this->hasMany(GroupRequest::class, 'group_id', 'id');
    }
}

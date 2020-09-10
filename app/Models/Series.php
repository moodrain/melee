<?php

namespace App\Models;

class Series extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
    ];

    public static $sortRule = ['id', 'createdAt', 'updatedAt'];

    protected $hidden = ['created_at', 'updated_at', 'pivot'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('orderByName', function($q) {
            return $q->orderBy('name');
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

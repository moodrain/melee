<?php

namespace App\Models;

use App\Models\Traits\Content;
use App\Models\Traits\TimeReadable;

class Post extends Model
{
    use TimeReadable, Content;

    public static $searchRule = [
        'id' => '=',
        'content' => 'like',
    ];

    public static $sortRule = ['id', 'createdAt', 'updatedAt'];

    protected $appends = ['createdAtReadable', 'updatedAtReadable', 'contentShort', 'contentBase64'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

}

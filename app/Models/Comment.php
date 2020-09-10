<?php

namespace App\Models;

use App\Models\Traits\Content;
use App\Models\Traits\TimeReadable;

class Comment extends Model
{
    use TimeReadable, Content;

    public static $searchRule = [
        'id' => '=',
        'postId/d' => '=',
        'user_name' => 'like',
        'user_email' => 'like',
        'content' => 'like',
    ];

    public static $sortRule = ['id', 'postId', 'createdAt', 'updatedAt'];

    protected $appends = ['createdAtReadable', 'updatedAtReadable', 'contentShort', 'contentBase64'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }


}

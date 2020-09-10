<?php

namespace App\Models;

class Link extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'url' => 'like',
    ];

    public static $sortRule = ['id', 'name', 'createdAt', 'updatedAt'];
}

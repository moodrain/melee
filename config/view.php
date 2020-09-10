<?php

return [

    'admin' => [
        'nav' => [
            ['dashboard', '面板', 'admin'],
            ['post', '文章', [
                ['post-list', '文章列表', 'admin/post/list'],
                ['post-edit', '文章编辑', 'admin/post/edit'],
            ]],
            ['comment', '留言', [
                ['comment-list', '留言列表', 'admin/comment/list'],
            ]],
            ['tag', '标签', [
                ['tag-list', '标签列表', 'admin/tag/list'],
                ['tag-edit', '标签编辑', 'admin/tag/edit'],
            ]],
            ['series', '系列', [
                ['series-list', '系列列表', 'admin/series/list'],
                ['series-edit', '系列编辑', 'admin/series/edit'],
            ]],
            ['link', '友链', [
                ['link-list', '友链列表', 'admin/link/list'],
                ['link-edit', '友链编辑', 'admin/link/edit'],
            ]],
        ],
    ],

    'user' => [
        'nav' => [
            'pc' => [
                ['post', '文章', ''],
                ['archive', '归档', 'archive'],
                ['about', '关于', 'post/1'],
            ],
            'mobile' => [
                ['post', '文章', ''],
                ['archive', '归档', 'archive'],
                ['about', '关于', 'post/1'],
            ],
        ],
    ],

    'nav' => [
        'auth' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];

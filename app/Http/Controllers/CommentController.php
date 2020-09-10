<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function comment()
    {
        $rules = [
            'userName' => '',
            'userEmail' => 'email',
            'postId' => 'required|int|exists:posts,id',
            'content' => 'required',
        ];
        if (Comment::query()->where('post_id', request('postId'))->count() >= 100) {
            return $this->backErr('该文章留言数已达上限');
        }
        $key = 'comment:count:' . request()->ip();
        ! cache()->has($key) && cache()->put($key, 0, 60 * 60);
        if (cache($key) > 10) {
            return $this->backErr('该 IP 留言数达上限，请稍后再试');
        }
        $this->vld($rules);
        cache()->increment($key);
        Comment::query()->create(request()->only(array_keys($rules)));
        try {
            $title = '博客留言 ' . request()->getHost();
            $user = request('userName', '匿名');
            $mail = request('userEmail');
            $body = request('content') . '<br /> 来自 ' . $user . ' ' . $mail;
            Http::get('http://mail.local.app/send', compact('title', 'body'));
        } catch (\Throwable $e) {}
        return $this->backOk();
    }
}
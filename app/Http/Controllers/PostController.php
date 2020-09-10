<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $builder = Post::query()->latest()->with(['tags', 'series']);
        request('title') && $builder->where('title', 'like', '%' . request('title') . '%');
        request('tag') && $builder->whereHas('tags', function($q) {
            $q->where('name', request('tag'));
        });
        request('series') && $builder->whereHas('series', function($q) {
            $q->where('name', request('series'));
        });
        $pager = $builder->paginate(10);
        return view('post.index', compact('pager'));
    }

    public function show(Post $post)
    {
        $post->load(['tags', 'series.posts', 'comments' => function($q) { $q->latest(); }]);
        return view('post.show', compact('post'));
    }

    public function archive()
    {
        $posts = Post::query()->latest()->get(['id', 'title', 'created_at', 'updated_at']);
        $posts = $posts->groupBy(function($p) {
            return $p->createdAt->year;
        });
        $years = collect();
        foreach($posts as $year => $yearPosts) {
            $yearPosts = $yearPosts->map(function($p) {
                $p->createdAtDate = $p->createdAt->format('Y-m-d');
                return $p;
            });
            $years->push([
                'year' => $year,
                'posts' => $yearPosts,
            ]);
        }
        $posts = $years;
        $tags = Tag::query()->get(['id', 'name']);
        $series = Series::query()->get(['id', 'name']);
        $links = Link::query()->get(['id', 'name', 'url']);
        return view('archive', compact('posts', 'tags', 'series', 'links'));
    }
}
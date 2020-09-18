<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $db = function() {
            return DB::table('request_logs')
                ->whereNull('user_id')
                ->where(function($q) {
                    $q->where('user_agent', 'not like', '%spider%')
                        ->where('user_agent', 'not like', '%Spider%')
                        ->where('user_agent', 'not like', '%SPIDER%');
                });
        };
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subDays(30);
        $dbMonth = function() use ($db, $now, $lastMonth) { return $db()->whereBetween('created_at', [$lastMonth, $now]); };
        $visitTotal = $db()->where(function($q) {
            $q->where('path', 'like', 'post/%')->orWhereIn('path', ['archive', '/']);
        })->count();
        $visitMonth = $dbMonth()->where(function($q) {
            $q->where('path', 'like', 'post/%')->orWhereIn('path', ['archive', '/']);
        })->count();
        $commentTotal = Comment::query()->count();
        $commentMonth = Comment::query()->whereBetween('created_at', [$lastMonth, $now])->count();
        $postTopRecords = $db()->where('path', 'like', 'post/%')
            ->selectRaw('cast(substr(path, 6) as unsigned) as post_id, count(*) as count')
            ->groupByRaw('post_id')
            ->orderByRaw('count desc')
            ->take(10)
            ->get();
        $postsTop = collect();
        foreach($postTopRecords as $postTopRecord) {
            $post = Post::query()->select('id', 'title')->find($postTopRecord->post_id);
            if ($post) {
                $post->visit = $postTopRecord->count;
                $postsTop->push($post);
            }
        }
        return $this->view('index', compact('visitTotal', 'visitMonth', 'commentTotal', 'commentMonth', 'postsTop'));
    }
}
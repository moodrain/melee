<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Services\OssService;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $model = 'post';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with(['tags', 'series'])->withCount('comments')->latest('updated_at');
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            $isUpdate = request()->filled('id');
            $this->rules = [
                'title' => 'required',
                'content' => 'required',
                'tags' => 'array',
                'tags.*' => 'required|int|exists:tags,id',
                'series_id' => 'nullable|exists:series,id',
            ];
            $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
            $this->vld();
            return $isUpdate ? $this->update() : $this->store();
        }
        return $this->view('edit', [
            'd' => request('id') ? $this->builder()->find(request('id')) : null,
        ]);
    }

    private function store()
    {
        $post = new Post(request()->only('title', 'content', 'series_id'));
        DB::beginTransaction();
        try {
            $post->save();
            $post->tags()->sync(request('tags'));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->backErr($e->getMessage());
        }
        return $this->directOk('post/list');
    }

    private function update()
    {
        $post = Post::query()->find(request('id'));
        $post->fill(request()->only('title', 'content', 'series_id'));
        DB::beginTransaction();
        try {
            $post->save();
            $post->tags()->sync(request('tags'));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->backErr($e->getMessage());
        }
        return $this->directOk('post/list');
    }

    public function destroy()
    {
        $this->vld([
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ]);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $post = Post::query()->find($id);
                $post->tags()->detach();
                $post->comments()->delete();
                $post->delete();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->backErr($e->getMessage());
        }
        return $this->backOk();
    }

    public function uploadImage(OssService $oss)
    {
        $this->vld(['file' => 'required|file']);
        $img = request()->file('file');
        $content = file_get_contents($img->getRealPath());
        $imgName = 'melee/img/' . md5($content) . '.' . $img->getClientOriginalExtension();
        try {
            $oss->put('moodrain', $imgName, $content);
        } catch (\Throwable $e) {
            return ers($e->getMessage());
        }
        return rs(config('aliyun.oss.cdn') . '/' . $imgName);
    }

    public function removeImage(OssService $oss)
    {
        $this->vld(['file' => 'required']);
        $img = basename(request('file'));
        $oss->delete('moodrain', 'melee/img/' . $img);
        return rs();
    }

}

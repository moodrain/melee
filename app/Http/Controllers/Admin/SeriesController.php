<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SeriesController extends Controller
{
    protected $model = 'series';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->withCount('posts');
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            $isUpdate = request()->filled('id');
            $this->rules = [];
            $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
            $this->rules['name'] = $isUpdate
                ? ['required', Rule::unique($this->table())->ignore(request('id'))]
                : 'required|unique:' . $this->table();
            $this->vld();
            return $isUpdate ? $this->update() : $this->store();
        }
        return $this->view('edit', [
            'd' => request('id') ? $this->builder()->find(request('id')) : null,
        ]);
    }

    private function store()
    {
        $item = $this->builder()->newModelInstance(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->viewOk('edit');
    }

    private function update()
    {
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
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
            expIf(Post::query()->whereIn('series_id', $ids)->exists(), '非空系列，无法删除');
            $this->builder()->whereIn('id', $ids)->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->backErr($e->getMessage());
        }
        return $this->backOk();
    }

}

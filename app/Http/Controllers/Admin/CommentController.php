<?php

namespace App\Http\Controllers\Admin;

class CommentController extends Controller
{
    protected $model = 'comment';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('post');
        return $this->view('list', ['l' => $builder->paginate()]);
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
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}

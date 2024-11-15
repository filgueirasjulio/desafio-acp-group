<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    private $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $tag = $this->find($id);
        $tag->update($data);

        return $tag;
    }

    public function destroy($tagId)
    {
        $this->model->destroy($tagId);
    }
}
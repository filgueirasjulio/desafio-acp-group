<?php

namespace App\Repositories;

use App\Models\Tag;
class TagRepository
{
    private Tag $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function find(int $id): ?Tag
    {
        return $this->model->find($id);
    }

    public function store(array $data): Tag
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Tag
    {
        $tag = $this->find($id);

        if (!$tag) {
            throw new \Exception("Tag not found.");
        }

        $tag->update($data);

        return $tag;
    }

    public function destroy(int $id): void
    {
        $tag = $this->model->find($id);

        if (!$tag) {
            throw new \Exception("Tag not found.");
        }

        $this->model->destroy($id);
    }
}

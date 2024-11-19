<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class TagRepository
{
    private Tag $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = null)
    {
        $result = $this->model;

        if(isset($filters['description'])) {
            $result = $result->where('slug', 'LIKE', '%'.$filters['description'].'%');
        }

        return $result->orderBy('description', 'asc')->paginate(20);
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

<?php

namespace App\Services\Api;

use App\Repositories\TagRepository;

class TagService
{
    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index(array $filters)
    {
        return $this->tagRepository->all($filters);
    }

    public function show(int $id)
    {
        return $this->tagRepository->find($id);
    }

    public function store(array $data)
    {
        return $this->tagRepository->store($data);
    }

    public function update(int $id, array $data)
    {
        return $this->tagRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->tagRepository->destroy($id);
    }
}

<?php

namespace App\Services\Api;

use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function show($id)
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

    public function delete($tagId)
    {
        $this->tagRepository->destroy($tagId);
    }
}
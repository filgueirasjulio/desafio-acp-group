<?php

namespace App\Services\Api;

use App\Repositories\PostRepository;

class PostService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function show(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function store(array $data)
    {
        return $this->postRepository->store($data);
    }

    public function update(int $id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->postRepository->destroy($id);
    }
}

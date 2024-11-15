<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    private Post $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function find(int $id): ?Post
    {
        return $this->model->find($id);
    }

    public function store(array $data): Post
    {
        $post = $this->model->create($data);
        $post->tags()->attach($data['tags']);

        return $post;
    }

    public function update(int $id, array $data): Post
    {
        $post = $this->find($id);

        if (!$post) {
            throw new \Exception("Post not found.");
        }

        $post->update($data);

        $post->tags()->sync($data['tags']);

        return $post;
    }

    public function destroy(int $id): void
    {
        $this->model->destroy($id);
    }
}

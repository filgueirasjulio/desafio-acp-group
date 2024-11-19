<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    private Post $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = null)
    {
        $result = $this->model->with('user', 'tags');

        if(isset($filters['user_id'])) {
            $result = $result->where('user_id', $filters['user_id']);
        }

        return $result->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): ?Post
    {
        return $this->model->find($id);
    }

    public function store(array $data): Post
    {
        $post = $this->model->create($data);

        if(isset($data['tags']) & !empty($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }

        return $post;
    }

    public function update(int $id, array $data): Post
    {
        $post = $this->find($id);

        if (!$post) {
            throw new \Exception("Post not found.");
        }

        $post->update($data);

        if(isset($data['tags']) & !empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function destroy(int $id): void
    {
        $this->model->destroy($id);
    }
}

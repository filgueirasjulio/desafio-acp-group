<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function show(int $id): PostResource
    {
        return new PostResource($this->postService->show($id));
    }

    public function store(PostRequest $request): PostResource
    {
        return new PostResource($this->postService->store($request->validated()));
    }

    public function update(PostRequest $request, int $id): PostResource
    {
        return new PostResource($this->postService->update($id, $request->validated()));
    }

    public function delete(int $id): JsonResponse
    {
        $this->postService->delete($id);

        return response()->json(['message' => 'Post deletado com sucesso!'], JsonResponse::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\PostService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): ResourceCollection
    {
        return PostResource::collection($this->postService->index($request->all()));
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

<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\TagService;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function show(int $id): TagResource
    {
        return new TagResource($this->tagService->show($id));
    }

    public function store(TagRequest $request): TagResource
    {
        return new TagResource($this->tagService->store($request->validated()));
    }

    public function update(TagRequest $request, int $id): TagResource
    {
        return new TagResource($this->tagService->update($id, $request->validated()));
    }

    public function delete(int $id): JsonResponse
    {
        $this->tagService->delete($id);

        return response()->json(['message' => 'Tag deletada com sucesso!'], JsonResponse::HTTP_OK);
    }
}

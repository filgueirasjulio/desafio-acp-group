<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\TagService;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function show($id): TagResource
    {
        $tag = $this->tagService->show($id);
       
        return new TagResource($tag);
    }

    public function store(TagRequest $request): TagResource
    {
        $tag = $this->tagService->store($request->validated());

        return new TagResource($tag);
    }

    public function update(TagRequest $request, int $id): TagResource
    {
        $tag = $this->tagService->update($id, $request->validated());

        return new TagResource($tag);
    }

    public function delete($tagId): JsonResponse
    {
        $this->tagService->delete($tagId);

        return response()->json(['message' => 'Tag deletada com sucesso!'], 200);
    }
}

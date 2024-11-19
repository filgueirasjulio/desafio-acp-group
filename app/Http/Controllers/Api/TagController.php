<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\TagService;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @OA\Get(
     *     path="/api/tag",
     *     tags={"Tags"},
     *     summary="Listar todas as tags",
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         required=false,
     *         description="Filtrar tags pela descrição",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tags"
     *     )
     * )
     */
    public function index(Request $request): ResourceCollection
    {
        return TagResource::collection($this->tagService->index($request->all()));
    }
    
    /**
     * @OA\Get(
     *     path="/api/tag/{id}/show",
     *     tags={"Tags"},
     *     summary="Exibir uma tag específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tag",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da tag"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag não encontrada"
     *     )
     * )
     */
    public function show(int $id): TagResource
    {
        return new TagResource($this->tagService->show($id));
    }

    /**
     * @OA\Post(
     *     path="/api/tag/store",
     *     tags={"Tags"},
     *     summary="Criar nova tag",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "bg_color"},
     *             @OA\Property(property="description", type="string", description="Descrição da tag"),
     *             @OA\Property(property="bg_color", type="string", description="Cor de fundo da tag")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tag criada com sucesso"
     *     )
     * )
     */
    public function store(TagRequest $request): TagResource
    {
        return new TagResource($this->tagService->store($request->validated()));
    }

    /**
     * @OA\Put(
     *     path="/api/tag/{id}/update",
     *     tags={"Tags"},
     *     summary="Atualizar uma tag",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tag a ser atualizada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "bg_color"},
     *             @OA\Property(property="description", type="string", description="Descrição da tag"),
     *             @OA\Property(property="bg_color", type="string", description="Cor de fundo da tag")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag atualizada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag não encontrada"
     *     )
     * )
     */
    public function update(TagRequest $request, int $id): TagResource
    {
        return new TagResource($this->tagService->update($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/api/tag/{id}/delete",
     *     tags={"Tags"},
     *     summary="Deletar uma tag",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tag a ser deletada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag não encontrada"
     *     )
     * )
     */
    public function delete(int $id): JsonResponse
    {
        $this->tagService->delete($id);

        return response()->json(['message' => 'Tag deletada com sucesso!'], JsonResponse::HTTP_OK);
    }
}

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

    /**
     * @OA\Get(
     *     path="/api/post",
     *     tags={"Posts"},
     *     summary="Lista de publicações",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",  
     *         description="ID do usuário para filtrar as publicações",
     *         required=false,  
     *         @OA\Schema(
     *             type="integer"  
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de publicações"
     *     )
     * )
     */
    public function index(Request $request): ResourceCollection
    {
        return PostResource::collection($this->postService->index($request->all()));
    }

    /**
     * @OA\Get(
     *     path="/api/post/{id}/show",
     *     tags={"Posts"},
     *     summary="Retornar postagem",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário para buscar as publicações",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da publicação"
     *     )
     * )
     */
    public function show(int $id): PostResource
    {
        return new PostResource($this->postService->show($id));
    }
  
    /**
     * @OA\Post(
     *     path="/api/post/store",
     *     tags={"Posts"},
     *     summary="Criar nova publicação",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "description"},
     *             @OA\Property(property="user_id", type="integer", description="ID do usuário"),
     *             @OA\Property(property="content", type="string", description="Conteúdo da publicação"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"), description="Tags associadas ao post (não obrigatórias)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Publicação criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na requisição"
     *     )
     * )
     */
    public function store(PostRequest $request): PostResource
    {
        return new PostResource($this->postService->store($request->validated()));
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Atualizar publicação existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da publicação para ser atualizada",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "content"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="integer"), description="Tags associadas ao post (não obrigatórias)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicação atualizada"
     *     )
     * )
     */
    public function update(PostRequest $request, int $id): PostResource
    {
        return new PostResource($this->postService->update($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     tags={"Posts"},
     *     summary="Excluir publicação",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da publicação a ser excluída",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publicação excluída com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Publicação não encontrada"
     *     )
     * )
     */
    public function delete(int $id): JsonResponse
    {
        $this->postService->delete($id);

        return response()->json(['message' => 'Post deletado com sucesso!'], JsonResponse::HTTP_OK);
    }
}

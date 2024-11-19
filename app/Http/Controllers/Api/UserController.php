<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\Api\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserUpdateRequest;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    /**
     * @OA\Info(
     *     title="ACPBook Doc",
     *     version="1.0.0",
     *     description="Documentação api AcpBook"
     * )
    */

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"Usuários"},
     *     summary="Listar todos os usuários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários"
     *     )
     * )
     */
    public function index(): ResourceCollection
    {
        return UserResource::collection($this->userService->index());
    }

        /**
     * @OA\Get(
     *     path="/api/user/{id}/show",
     *     tags={"Usuários"},
     *     summary="Exibir detalhes de um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do usuário"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     )
     * )
     */
    public function show(int $id): UserResource
    {
        return new UserResource($this->userService->show($id));
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}/update",
     *     tags={"Usuários"},
     *     summary="Atualizar dados do usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Ação não autorizada"
     *     ) 
     * )
     */
    public function update(UserUpdateRequest $request, int $id): UserResource|JsonResponse
    {
        try {
            return new UserResource($this->userService->update($id, $request->validated()));
        } catch (UnauthorizedActionException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}/delete",
     *     tags={"Usuários"},
     *     summary="Deletar um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Ação não autorizada"
     *     ) 
     * )
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $this->userService->delete($id);

            return response()->json(['message' => 'Usuário deletado com sucesso!'], JsonResponse::HTTP_OK);
        } catch (UnauthorizedActionException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}

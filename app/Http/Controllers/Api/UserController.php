<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\UserService;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(int $id): UserResource
    {
        return new UserResource($this->userService->show($id));
    }

    public function update(UserUpdateRequest $request, int $id): UserResource
    {
        return new UserResource($this->userService->update($id, $request->validated()));
    }

    public function delete(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return response()->json(['message' => 'Usuário deletado com sucesso!'], JsonResponse::HTTP_OK);
    }
}

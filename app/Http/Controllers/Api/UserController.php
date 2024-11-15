<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Api\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show($id): UserResource
    {
        $user = $this->userService->show($id);
       
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, int $id): UserResource
    {
        $user = $this->userService->update($id, $request->validated());

        return new UserResource($user);
    }

    public function delete($userId): JsonResponse
    {
        $this->userService->delete($userId);

        return response()->json(['message' => 'Usuário deletado com sucesso!'], 200);
    }
}

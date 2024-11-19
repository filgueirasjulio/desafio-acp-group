<?php

namespace App\Services\Api;

use App\Repositories\UserRepository;
use App\Exceptions\UnauthorizedActionException;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->all();
    }

    public function show(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        $this->validateUserPermission($id);

        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->validateUserPermission($id);

        $this->userRepository->destroy($id);
    }

    private function validateUserPermission(int $id): void
    {
        if ((auth()->user())->id !== $id) {
            throw new UnauthorizedActionException();
        }
    }
}

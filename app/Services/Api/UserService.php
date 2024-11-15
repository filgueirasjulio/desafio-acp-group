<?php

namespace App\Services\Api;

use App\Repositories\UserRepository;
class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->userRepository->destroy($id);
    }
}

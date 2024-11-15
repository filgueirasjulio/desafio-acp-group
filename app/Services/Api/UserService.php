<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\IrmãoRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show($id)
    {
        return $this->userRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete($userId)
    {
        $this->userRepository->destroy($userId);
    }
}
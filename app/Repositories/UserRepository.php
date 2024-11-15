<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        if (!$user) {
            throw new \Exception("User not found.");
        }

        $user->update($data);

        return $user;
    }

    public function destroy(int $id): void
    {
        $user = $this->model->find($id);

        if (!$user) {
            throw new \Exception("User not found.");
        }

        $this->model->destroy($id);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);

        return $user;
    }

    public function destroy($userId)
    {
        $this->model->destroy($userId);
    }
}

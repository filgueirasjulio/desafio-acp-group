<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find($id)
    {
        return User::find($id);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);

        return $user;
    }

    public function destroy($userId)
    {
        User::destroy($userId);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Larasitory\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
     /**
     * Set model database
     *
     * @return mixed|string
     */
    public function model()
    {
        return User::class;
    }

    public function findByEmail(string $email)
    {
        $this->where('email', $email);
        return $this->get();
    }
}

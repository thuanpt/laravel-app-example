<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    #[\App\Repositories\UserRepository]
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        //
    }

    public function register($validatedData)
    {
        try {
            $user = $this->userRepository->create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
        } catch (\Exception $exception) {
            report($exception);
            return false;
        }
    }

    public function login($email)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return false;
        }
        $token = $user->first()->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }
}

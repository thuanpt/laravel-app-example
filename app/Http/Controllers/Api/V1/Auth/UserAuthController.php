<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        //
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = $this->userService->register($validatedData);

        if ($user) {
            return response()->json([
                'data' => $user,
            ], 201);
        }

        return response()->json([
            'message' => 'Error!',
        ], 400);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $data = $this->userService->login($request['email']);

        if (!$data) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        return response()->json([$data], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}

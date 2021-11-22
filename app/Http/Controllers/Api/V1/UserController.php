<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function index()
    {
        return response()->json([$this->userService->getAll()], 200);
    }
}

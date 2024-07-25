<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;

class LoginController extends MainController
{
    public function __invoke(UserService $service, LoginRequest $request)
    {
        return $this->handleRequest(function () use ($service, $request) {
            $credentials = $request->validated();
            $user = $service->checkLoginUser($credentials);
            return [
                'user' => $user,
                'token' => $user->createToken('MyApp')->plainTextToken
            ];
        });
    }
}

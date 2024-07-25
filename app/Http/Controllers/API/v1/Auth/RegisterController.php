<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;

class RegisterController extends MainController
{
    public function __invoke(UserService $service, RegisterRequest $request)
    {
        return $this->handleRequest(function () use ($service, $request) {
            $data = $request->validated();
            $user = $service->store($data);
            return [
                'user' => $user,
                'token' => $user->createToken('MyApp')->plainTextToken
            ];
        });
    }
}

<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\MainController;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends MainController
{
    public function profile(UserService $service)
    {
        return $this->handleRequest(function () use ($service) {
           return UserResource::make($service->show(auth()->user()->id))->resolve();
        });
    }

    public function show(UserService $service, string $id)
    {
        return $this->handleRequest(function () use ($service, $id) {
            return UserResource::make($service->show($id))->resolve();
        });
    }

    public function update(UserService $service, UserUpdateRequest $request, string $id)
    {
        return $this->handleRequest(function () use ($service, $request, $id) {
            $data = $request->validated();
            $service->update($id, $data);
        });
    }
}

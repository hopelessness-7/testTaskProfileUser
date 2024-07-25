<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show(string $id): Model
    {
        return $this->userRepository->find($id);
    }

    public function store(array $data): Model
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function update(string $id, array $data): void
    {
        $data = array_filter($data, function($value) {
            return !is_null($value);
        });

        if (array_key_exists('password',$data)) {
            $data['password'] = Hash::make($data['password']);
        }

        $this->userRepository->update($id, $data);
    }

    public function checkLoginUser($credentials): Authenticatable|null
    {
        if (auth()->attempt($credentials)) {
            return auth()->user();
        } else {
            throw new \Exception('credentials are incorrect', 423);
        }
    }
}

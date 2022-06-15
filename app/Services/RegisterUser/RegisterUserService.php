<?php

namespace App\Services\RegisterUser;

use App\Models\User;

class RegisterUserService
{
    public function run(RegisterUserRequest $request): void
    {
        User::createUser($request->getUsername(), $request->getEmail(), $request->getPassword());
    }
}

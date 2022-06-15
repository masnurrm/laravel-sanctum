<?php

namespace App\Services\LoginUser;

use App\Exceptions\ExpectedException;
use App\Models\NonOrmModels\UserAbility;
use App\Models\User;
use Hash;

class LoginUserService
{
    /**
     * @throws \App\Exceptions\ExpectedException
     */
    public function run(LoginUserRequest $request): LoginUserResponse
    {
        $user = User::where('name', $request->getUsernameOrEmail())
            ->orWhere('email', $request->getUsernameOrEmail())->first();
        if (!$user) throw new ExpectedException("User not found", 1002, 401);
        if (Hash::check($request->getPassword(), $user->password)) {
            $token = $user->createToken('default_token', UserAbility::getUserAbility($user));
            return new LoginUserResponse($token->plainTextToken);
        }
        throw new ExpectedException("invalid login!", 1003, 401);
    }
}

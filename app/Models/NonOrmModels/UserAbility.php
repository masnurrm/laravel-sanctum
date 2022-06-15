<?php

namespace App\Models\NonOrmModels;

use App\Exceptions\ExpectedException;
use App\Models\User;

class UserAbility extends CustomEnum
{
    public const ADMIN = ['*'];
    public const USER = ['read'];

    /**
     * @param User $user
     * @return string[]
     * @throws ExpectedException
     */
    public static function getUserAbility(User $user): array
    {
        switch ($user->type) {
            case UserType::USER:
                return UserAbility::USER;
            case UserType::ADMIN:
                return UserAbility::ADMIN;
            default:
                throw new ExpectedException('invalid user type', 1000);
        }
    }
}

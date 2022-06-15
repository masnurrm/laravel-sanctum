<?php

namespace App\Services\LoginUser;

use JetBrains\PhpStorm\Internal\TentativeType;

class LoginUserResponse implements \JsonSerializable
{
    private string $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function jsonSerialize(): array
    {
        return [
            "token" => $this->token
        ];
    }
}

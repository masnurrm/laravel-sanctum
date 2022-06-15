<?php

namespace App\Services\LoginUser;

class LoginUserRequest
{
    private string $username_or_email;
    private string $password;

    /**
     * @param string $username_or_email
     * @param string $password
     */
    public function __construct(string $username_or_email, string $password)
    {
        $this->username_or_email = $username_or_email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsernameOrEmail(): string
    {
        return $this->username_or_email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ExpectedException extends Exception
{
    private int $status_code;

    public function __construct(string $message, int $code, int $status_code = 500)
    {
        $this->status_code = $status_code;
        parent::__construct($message, $code);
    }

    public function render(): Response
    {
        return response()->json([
            "success" => false,
            "message" => $this->message,
            "code" => $this->code
        ], $this->status_code);
    }
}

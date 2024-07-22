<?php

namespace App\Exceptions\Character;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundCharacterException extends HttpException
{
    public function __construct(
        string $message = 'Character not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

<?php

namespace App\Exceptions\Character;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundCharacter extends HttpException
{
    public function __construct(
        string $message = 'Character not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

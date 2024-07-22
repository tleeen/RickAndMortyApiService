<?php

namespace App\Exceptions\Character\Origin;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundOriginException extends HttpException
{
    public function __construct(
        string $message = 'Origin Not Found',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

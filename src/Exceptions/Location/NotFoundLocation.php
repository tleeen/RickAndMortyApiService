<?php

namespace App\Exceptions\Location;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundLocation extends HttpException
{
    public function __construct(
        string $message = 'Location not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

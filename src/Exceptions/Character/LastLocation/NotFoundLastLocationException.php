<?php

namespace App\Exceptions\Character\LastLocation;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundLastLocationException extends HttpException
{
    public function __construct(
        string $message = 'Last location not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

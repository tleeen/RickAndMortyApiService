<?php

namespace App\Exceptions\Character\LastLocation;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundLastLocation extends HttpException
{
    public function __construct(
        string $message = 'Last location not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

<?php

declare(strict_types=1);

namespace App\Exceptions\Validation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateException extends HttpException
{
    public function __construct(
        string $message,
        int $code = Response::HTTP_BAD_REQUEST,
    ) {
        parent::__construct($code, $message);
    }
}

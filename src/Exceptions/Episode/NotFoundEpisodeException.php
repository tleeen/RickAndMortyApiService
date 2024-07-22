<?php

namespace App\Exceptions\Episode;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundEpisodeException extends HttpException
{
    public function __construct(
        string $message = 'Episode not found.',
        int $code = 404,
    ) {
        parent::__construct($code, $message);
    }
}

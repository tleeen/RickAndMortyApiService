<?php

declare(strict_types=1);

namespace App\Contracts\Managers\Validation;

use App\Exceptions\Validation\ValidateException;

interface ValidateManagerInterface
{
    /**
     * @throws ValidateException
     */
    public function validate(mixed $value): void;
}
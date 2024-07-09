<?php

namespace App\Contracts\Managers\Validation;

interface ValidateManagerInterface
{
    /**
     * @param mixed $value
     * @return void
     */
    public function validate(mixed $value): void;
}
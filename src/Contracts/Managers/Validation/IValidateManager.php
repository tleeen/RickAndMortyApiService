<?php

namespace App\Contracts\Managers\Validation;

interface IValidateManager
{
    /**
     * @param mixed $value
     * @return void
     */
    public function validate(mixed $value): void;
}
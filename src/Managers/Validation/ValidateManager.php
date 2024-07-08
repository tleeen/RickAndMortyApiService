<?php

namespace App\Managers\Validation;


use App\Contracts\Managers\Validation\IValidateManager;
use App\Exceptions\Validation\ValidateException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateManager implements IValidateManager
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {}

    /**
     * @param mixed $value
     * @return void
     * @throws ValidateException
     */
    public function validate(mixed $value): void
    {
        $errors = $this->validator->validate($value);

        if (count($errors) > 0) {
            throw new ValidateException((string)$errors);
        }
    }
}
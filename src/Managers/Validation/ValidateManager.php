<?php

declare(strict_types=1);

namespace App\Managers\Validation;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Exceptions\Validation\ValidateException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ValidateManager implements ValidateManagerInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    /**
     * @throws ValidateException
     */
    public function validate(mixed $value): void
    {
        $errors = $this->validator->validate($value);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                /* @var ConstraintViolationInterface $error */
                $errorMessages[] = $error->getMessage();
            }
            throw new ValidateException(implode(', ', $errorMessages));
        }
    }
}

<?php

namespace App\Enums\Character;

enum CharacterGender: string
{
    case FEMALE = 'Female';
    case MALE = 'Male';
    case GENDERLESS = 'Genderless';
    case UNKNOWN = 'unknown';

    public static function getChoices(): array
    {
        return array_column(self::cases(), 'value');
    }
}
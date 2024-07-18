<?php

declare(strict_types=1);

namespace App\Enums\Character;

enum CharacterStatus: string
{
    case ALIVE = 'Alive';
    case DEAD = 'Dead';
    case UNKNOWN = 'unknown';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

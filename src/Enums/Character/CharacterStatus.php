<?php

namespace App\Enums\Character;

enum CharacterStatus: string
{
    case ALIVE = 'Alive';
    case DEAD = 'Dead';
    case UNKNOWN = 'unknown';
}
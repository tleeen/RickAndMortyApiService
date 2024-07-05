<?php

namespace App\DTO\Enums\Prefixes;

enum ModulePrefixes: string
{
    case LOCATIONS = '/location';
    case CHARACTERS = '/character';
    case EPISODES = '/episode';
}
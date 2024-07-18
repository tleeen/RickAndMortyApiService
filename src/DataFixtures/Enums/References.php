<?php

declare(strict_types=1);

namespace App\DataFixtures\Enums;

enum References: string
{
    case LOCATION = 'location_';
    case CHARACTER = 'character_';
    case EPISODE = 'episode_';
}
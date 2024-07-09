<?php

namespace App\DTO\Out\Character;

use App\DTO\Out\Location\ShortLocationDto;

class CharacterDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $status;
    public readonly string $species;
    public readonly ?string $type;
    public readonly string $gender;
    public readonly ShortLocationDto $origin;
    public readonly ShortLocationDto $location;
    public readonly string $image;
    public readonly array $episode;
    public readonly string $url;
    public readonly string $created;


    public function __construct(
        int    $id,
        string  $name,
        string  $status,
        string  $species,
        ?string $type,
        string  $gender,
        ShortLocationDto $origin,
        ShortLocationDto $location,
        string $image,
        array $episode,
        string $url,
        string $created
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->type = $type;
        $this->gender = $gender;
        $this->origin = $origin;
        $this->location = $location;
        $this->image = $image;
        $this->episode = $episode;
        $this->url = $url;
        $this->created = $created;
    }
}
<?php

namespace App\DTO\Out\Character;

use App\DTO\Out\Location\ShortLocationDto;

readonly class CharacterDto
{
    public int $id;
    public string $name;
    public string $status;
    public string $species;
    public ?string $type;
    public string $gender;
    public ShortLocationDto $origin;
    public ShortLocationDto $location;
    public string $image;
    public array $episode;
    public string $url;
    public string $created;


    public function __construct(
        int              $id,
        string           $name,
        string           $status,
        string           $species,
        ?string          $type,
        string           $gender,
        ShortLocationDto $origin,
        ShortLocationDto $location,
        string           $image,
        array            $episode,
        string           $url,
        string           $created
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
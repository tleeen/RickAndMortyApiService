<?php

namespace App\DTO\Out\Location;

readonly class LocationDto
{
    public int $id;
    public string $name;
    public string $type;
    public string $dimension;
    public array $residents;
    public string $url;
    public string $created;


    public function __construct(
        int    $id,
        string $name,
        string $type,
        string $dimension,
        array  $residents,
        string $url,
        string $created,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
        $this->residents = $residents;
        $this->url = $url;
        $this->created = $created;
    }
}
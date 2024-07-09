<?php

namespace App\DTO\Out\Location;

class LocationDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $type;
    public readonly string $dimension;
    public readonly array $residents;
    public readonly string $url;
    public readonly string $created;


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
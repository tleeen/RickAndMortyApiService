<?php

namespace App\DTO\Out\Episode;

class EpisodeDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $air_date;
    public readonly string $episode;
    public readonly array $characters;
    public readonly string $url;
    public readonly string $created;


    public function __construct(
        int    $id,
        string $name,
        string $air_date,
        string $episode,
        array  $characters,
        string $url,
        string $created,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->air_date = $air_date;
        $this->episode = $episode;
        $this->characters = $characters;
        $this->url = $url;
        $this->created = $created;
    }
}
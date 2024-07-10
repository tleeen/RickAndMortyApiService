<?php

namespace App\DTO\Out\Episode;

readonly class EpisodeDto
{
    public int $id;
    public string $name;
    public string $air_date;
    public string $episode;
    public array $characters;
    public string $url;
    public string $created;


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
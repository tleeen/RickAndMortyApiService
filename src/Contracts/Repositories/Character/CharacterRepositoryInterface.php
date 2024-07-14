<?php

namespace App\Contracts\Repositories\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;

interface CharacterRepositoryInterface
{
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto;

    public function findById(int $id): CharacterDto;

    public function delete(int $id): void;

    public function create(CreateCharacterDto $createCharacterDto): CharacterDto;

    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto;

    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto;
}
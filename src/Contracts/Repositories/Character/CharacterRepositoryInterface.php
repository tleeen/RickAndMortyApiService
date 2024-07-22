<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Exceptions\Character\LastLocation\NotFoundLastLocation;
use App\Exceptions\Character\NotFoundCharacter;
use App\Exceptions\Character\Origin\NotFoundOrigin;

interface CharacterRepositoryInterface
{
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto;

    /**
     * @throws NotFoundCharacter
     */
    public function findById(int $id): CharacterDto;

    /**
     * @throws NotFoundCharacter
     */
    public function delete(int $id): void;

    /**
     * @throws NotFoundLastLocation
     * @throws NotFoundOrigin
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto;

    /**
     * @throws NotFoundCharacter
     * @throws NotFoundLastLocation
     * @throws NotFoundOrigin
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto;

    /**
     * @throws NotFoundLastLocation
     * @throws NotFoundOrigin
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto;
}

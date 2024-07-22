<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Exceptions\Character\LastLocation\NotFoundLastLocationException;
use App\Exceptions\Character\NotFoundCharacterException;
use App\Exceptions\Character\Origin\NotFoundOriginException;

interface CharacterRepositoryInterface
{
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto;

    /**
     * @throws NotFoundCharacterException
     */
    public function findById(int $id): CharacterDto;

    /**
     * @throws NotFoundCharacterException
     */
    public function delete(int $id): void;

    /**
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto;

    /**
     * @throws NotFoundCharacterException
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto;

    /**
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto;
}

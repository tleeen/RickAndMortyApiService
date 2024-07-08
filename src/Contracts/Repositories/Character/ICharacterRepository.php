<?php

namespace App\Contracts\Repositories\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use Doctrine\ORM\Exception\ORMException;

interface ICharacterRepository
{
    /**
     * @param GetCharactersDto $getCharactersDto
     * @return PaginateDto
     */
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto;

    /**
     * @param int $id
     * @return CharacterDto
     */
    public function findById(int $id): CharacterDto;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param CreateCharacterDto $createCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto;

    /**
     * @param ChangeCharacterDto $changeCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto;

    /**
     * @param UpdateCharacterDto $updateCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto;
}
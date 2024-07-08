<?php

namespace App\Repository;

use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Entity\Location;
use App\Managers\PaginatorManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginatorManager $paginatorManager
    )
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param GetCharactersDto $getCharactersDto
     * @return PaginateDto
     */
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto
    {
        $qb = $this->createQueryBuilder('character');

        if ($getCharactersDto->ids) {
            $qb->andWhere('character.id IN (:ids)')
                ->setParameter('ids', $getCharactersDto->ids);
        }

        return CharacterDto::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getCharactersDto->page ?: 1));
    }

    /**
     * @param int $id
     * @return CharacterDto
     */
    public function findById(int $id): CharacterDto
    {
        return CharacterDto::fromModel($this->find($id));
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
    }

    /**
     * @param CreateCharacterDto $createCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto
    {
        $character = new Character();

        $this->setAttributes($character, [
            'name' => $createCharacterDto->name,
            'status' => $createCharacterDto->status,
            'species' => $createCharacterDto->species,
            'type' => $createCharacterDto->type,
            'gender' => $createCharacterDto->gender,
            'origin' => $createCharacterDto->originId,
            'lastLocation' => $createCharacterDto->locationId,
            'image' => $createCharacterDto->image]);

        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();

        return CharacterDto::fromModel($character);
    }

    /**
     * @param ChangeCharacterDto $changeCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto
    {
        /** @var Character $character */
        $character = $this->find($changeCharacterDto->id);

        $this->setAttributes($character, [
            'name' => $changeCharacterDto->name,
            'status' => $changeCharacterDto->status,
            'species' => $changeCharacterDto->species,
            'type' => $changeCharacterDto->type,
            'gender' => $changeCharacterDto->gender,
            'origin' => $changeCharacterDto->originId,
            'lastLocation' => $changeCharacterDto->locationId,
            'image' => $changeCharacterDto->image]);

        $this->getEntityManager()->flush();

        return CharacterDto::fromModel($character);
    }

    /**
     * @param UpdateCharacterDto $updateCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto
    {
        /** @var Character $character */
        $character = $this->find($updateCharacterDto->id);

        if (!$character) {
            $character = new Character();
        }

        $this->setAttributes($character, [
            'name' => $updateCharacterDto->name,
            'status' => $updateCharacterDto->status,
            'species' => $updateCharacterDto->species,
            'type' => $updateCharacterDto->type,
            'gender' => $updateCharacterDto->gender,
            'origin' => $updateCharacterDto->originId,
            'lastLocation' => $updateCharacterDto->locationId,
            'image' => $updateCharacterDto->image]);

        $this->getEntityManager()->flush();

        return CharacterDto::fromModel($character);
    }

    /**
     * @param Character $character
     * @param array $attributes
     * @return void
     * @throws ORMException
     */
    private function setAttributes(Character $character, array $attributes): void
    {
        $em = $this->getEntityManager();

        if (isset($attributes['name'])) dd($attributes['name']);
        if (isset($dto->status)) $character->setStatus($dto->status);
        if (isset($dto->species)) $character->setSpecies($dto->species);
        if (isset($dto->type)) $character->setType($dto->type);
        if (isset($dto->gender)) $character->setGender($dto->gender);
        if (isset($dto->originId)) $character->setOrigin($em->getReference(Location::class, $dto->originId));
        if (isset($dto->locationId)) $character->setLastLocation($em->getReference(Location::class, $dto->locationId));
        if (isset($dto->image)) $character->setImage($dto->image);
    }
}

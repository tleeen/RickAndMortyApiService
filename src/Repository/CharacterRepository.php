<?php

namespace App\Repository;

use App\DTO\Collection\CollectionDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\Entity\Character;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param $getLocationsDto
     * @return CollectionDto
     */
    public function findMany($getLocationsDto): CollectionDto
    {
        if (empty($getLocationsDto->ids)) {
            return CollectionDto::fromArray(
                $this->findAll(),
                CharacterDto::class);
        } else {
            return CollectionDto::fromArray(
                $this->findBy(['id' => $getLocationsDto->ids]),
                CharacterDto::class);
        }
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

        $character->setName($createCharacterDto->name);
        $character->setStatus($createCharacterDto->status);
        $character->setSpecies($createCharacterDto->species);
        $character->setType($createCharacterDto->type);
        $character->setGender($createCharacterDto->gender);
        $character->setOrigin($this
            ->getEntityManager()
            ->getReference(Location::class, $createCharacterDto->originId));
        $character->setLastLocation($this
            ->getEntityManager()
            ->getReference(Location::class, $createCharacterDto->locationId));
        $character->setImage($createCharacterDto->image);

        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();

        return CharacterDto::fromModel($character);
    }

    /**
     * @param UpdateCharacterDto $updateCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function change(UpdateCharacterDto $updateCharacterDto): CharacterDto
    {
        /** @var Character $character */
        $character = $this->find($updateCharacterDto->id);

        if ($updateCharacterDto->name) {
            $character->setName($updateCharacterDto->name);
        }
        if ($updateCharacterDto->status) {
            $character->setStatus($updateCharacterDto->status);
        }
        if ($updateCharacterDto->species) {
            $character->setSpecies($updateCharacterDto->species);
        }
        if ($updateCharacterDto->type) {
            $character->setType($updateCharacterDto->type);
        }
        if ($updateCharacterDto->gender) {
            $character->setGender($updateCharacterDto->gender);
        }
        if ($updateCharacterDto->originId) {
            $character->setOrigin($this
                ->getEntityManager()
                ->getReference(Location::class, $updateCharacterDto->originId));
        }
        if ($updateCharacterDto->locationId) {
            $character->setLastLocation($this
                ->getEntityManager()
                ->getReference(Location::class, $updateCharacterDto->locationId));
        }
        if ($updateCharacterDto->image) {
            $character->setImage($updateCharacterDto->image);
        }

        $this->getEntityManager()->flush();

        return CharacterDto::fromModel($character);
    }
}

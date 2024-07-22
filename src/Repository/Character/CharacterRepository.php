<?php

declare(strict_types=1);

namespace App\Repository\Character;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Mappers\Out\Character\CharacterDtoMapperInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Entity\Location;
use App\Exceptions\Character\LastLocation\NotFoundLastLocationException;
use App\Exceptions\Character\NotFoundCharacterException;
use App\Exceptions\Character\Origin\NotFoundOriginException;
use App\Filter\Filters\Character\CharacterFilterFactory;
use App\Filter\HasFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository implements CharacterRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginateManagerInterface $paginatorManager,
        private readonly CharacterDtoMapperInterface $characterDtoMapper
    ) {
        parent::__construct($registry, Character::class);
    }

    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto
    {
        $queryBuilder = $this->createQueryBuilder('character');

        $queryBuilder = $this->filterBy($queryBuilder, CharacterFilterFactory::create($getCharactersDto->filters));

        if (isset($getCharactersDto->ids)) {
            $queryBuilder->andWhere('character.id IN (:ids)')
                ->setParameter('ids', $getCharactersDto->ids);
        }

        return $this->characterDtoMapper->fromPaginator($this
            ->paginatorManager
            ->paginate($queryBuilder, $getCharactersDto->page, $getCharactersDto->limit)
        );
    }

    /**
     * @throws NotFoundCharacterException
     */
    public function findById(int $id): CharacterDto
    {
        $character = $this->find($id);

        if (!isset($character)) {
            throw new NotFoundCharacterException();
        }

        return $this->characterDtoMapper->fromModel($character);
    }

    /**
     * @throws NotFoundCharacterException
     */
    public function delete(int $id): void
    {
        $character = $this->find($id);

        if (!isset($character)) {
            throw new NotFoundCharacterException();
        }

        $this->getEntityManager()->remove($character);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto
    {
        $character = new Character();
        $this->setAttributes($character, $createCharacterDto);
        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();

        return $this->characterDtoMapper->fromModel($character);
    }

    /**
     * @throws NotFoundCharacterException
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto
    {
        $character = $this->find($changeCharacterDto->id);

        if (!isset($character)) {
            throw new NotFoundCharacterException();
        }

        $this->setAttributes($character, $changeCharacterDto);
        $this->getEntityManager()->flush();

        return $this->characterDtoMapper->fromModel($character);
    }

    /**
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto
    {
        $character = $this->find($updateCharacterDto->id);

        if (!isset($character)) {
            $character = new Character();
        }

        $this->setAttributes($character, $updateCharacterDto);
        $this->getEntityManager()->flush();

        return $this->characterDtoMapper->fromModel($character);
    }

    /**
     * @throws NotFoundLastLocationException
     * @throws NotFoundOriginException
     */
    private function setAttributes(
        Character $character,
        UpdateCharacterDto|ChangeCharacterDto|CreateCharacterDto $characterDto
    ): void {
        $entityManager = $this->getEntityManager();

        if (isset($characterDto->name)) {
            $character->setName($characterDto->name);
        }
        if (isset($characterDto->status)) {
            $character->setStatus($characterDto->status);
        }
        if (isset($characterDto->species)) {
            $character->setSpecies($characterDto->species);
        }
        if (isset($characterDto->type)) {
            $character->setType($characterDto->type);
        }
        if (isset($characterDto->gender)) {
            $character->setGender($characterDto->gender);
        }
        if (isset($characterDto->originId)) {
            $origin = $entityManager->find(Location::class, $characterDto->originId);
            if (!isset($origin)) {
                throw new NotFoundOriginException();
            }
            $character->setOrigin($origin);
        }
        if (isset($characterDto->locationId)) {
            $lastLocation = $entityManager->find(Location::class, $characterDto->locationId);
            if (!isset($lastLocation)) {
                throw new NotFoundLastLocationException();
            }
            $character->setLastLocation($lastLocation);
        }
        if (isset($characterDto->image)) {
            $character->setImage($characterDto->image);
        }
    }
}

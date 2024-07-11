<?php

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
        ManagerRegistry                              $registry,
        private readonly PaginateManagerInterface    $paginatorManager,
        private readonly CharacterDtoMapperInterface $characterDtoMapper
    )
    {
        parent::__construct($registry, Character::class);
    }

    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto
    {
        $queryBuilder = $this->createQueryBuilder('character');

        $queryBuilder = $this->filterBy($queryBuilder, CharacterFilterFactory::create($getCharactersDto->filters));

        if ($getCharactersDto->ids) {
            $queryBuilder->andWhere('character.id IN (:ids)')
                ->setParameter('ids', $getCharactersDto->ids);
        }

        return $this->characterDtoMapper->fromPaginator($this
            ->paginatorManager
            ->paginate($queryBuilder, $getCharactersDto->page ?: 1, $getCharactersDto->limit ?: 10)
        );
    }

    public function findById(int $id): CharacterDto
    {
        return $this->characterDtoMapper->fromModel($this->find($id));
    }

    public function delete(int $id): void
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
    }

    public function create(CreateCharacterDto $createCharacterDto): CharacterDto
    {
        $character = new Character();
        $this->setAttributes($character, $createCharacterDto);
        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();
        return $this->characterDtoMapper->fromModel($character);
    }

    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto
    {
        $character = $this->find($changeCharacterDto->id);
        $this->setAttributes($character, $changeCharacterDto);
        $this->getEntityManager()->flush();
        return $this->characterDtoMapper->fromModel($character);
    }

    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto
    {
        $character = $this->find($updateCharacterDto->id);
        $this->setAttributes($character, $updateCharacterDto);
        $this->getEntityManager()->flush();
        return $this->characterDtoMapper->fromModel($character);
    }

    private function setAttributes(
        Character $character,
        UpdateCharacterDto|ChangeCharacterDto|CreateCharacterDto $characterDto
    ): void
    {
        $em = $this->getEntityManager();

        if ($characterDto->name) $character->setName($characterDto->name);
        if ($characterDto->status) $character->setStatus($characterDto->status);
        if ($characterDto->species) $character->setSpecies($characterDto->species);
        if ($characterDto->type) $character->setType($characterDto->type);
        if ($characterDto->gender) $character->setGender($characterDto->gender);
        if ($characterDto->originId)
            $character->setOrigin($em->getReference(Location::class, $characterDto->originId));
        if ($characterDto->locationId)
            $character->setLastLocation($em->getReference(Location::class, $characterDto->locationId));
        if ($characterDto->image) $character->setImage($characterDto->image);
    }
}

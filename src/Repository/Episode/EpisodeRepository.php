<?php

declare(strict_types=1);

namespace App\Repository\Episode;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Mappers\Out\Episode\EpisodeDtoMapperInterface;
use App\Contracts\Repositories\Episode\EpisodeRepositoryInterface;
use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Entity\Episode;
use App\Exceptions\Character\NotFoundCharacter;
use App\Exceptions\Episode\NotFoundEpisode;
use App\Filter\Filters\Episode\EpisodeFilterFactory;
use App\Filter\HasFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Episode>
 */
class EpisodeRepository extends ServiceEntityRepository implements EpisodeRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginateManagerInterface $paginatorManager,
        private readonly EpisodeDtoMapperInterface $episodeDtoMapper
    ) {
        parent::__construct($registry, Episode::class);
    }

    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto
    {
        $queryBuilder = $this->createQueryBuilder('episode');

        $queryBuilder = $this->filterBy($queryBuilder, EpisodeFilterFactory::create($getEpisodeDto->filters));

        if (isset($getEpisodeDto->ids)) {
            $queryBuilder->andWhere('episode.id IN (:ids)')
                ->setParameter('ids', $getEpisodeDto->ids);
        }

        return $this->episodeDtoMapper->fromPaginator($this
            ->paginatorManager
            ->paginate($queryBuilder, $getEpisodeDto->page, $getEpisodeDto->limit),
        );
    }

    /**
     * @throws NotFoundEpisode
     */
    public function findById(int $id): EpisodeDto
    {
        $episode = $this->find($id);
        if (!isset($episode)) {
            throw new NotFoundEpisode();
        }

        return $this->episodeDtoMapper->fromModel($episode);
    }

    /**
     * @throws NotFoundEpisode
     */
    public function delete(int $id): void
    {
        $episode = $this->find($id);
        if (!isset($episode)) {
            throw new NotFoundEpisode();
        }
        $this->getEntityManager()->remove($episode);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NotFoundCharacter
     */
    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto
    {
        $episode = new Episode();
        $this->setAttributes($episode, $createEpisodeDto);
        $this->getEntityManager()->persist($episode);
        $this->getEntityManager()->flush();

        return $this->episodeDtoMapper->fromModel($episode);
    }

    /**
     * @throws NotFoundCharacter
     * @throws NotFoundEpisode
     */
    public function change(ChangeEpisodeDto $changeEpisodeDto): EpisodeDto
    {
        $episode = $this->find($changeEpisodeDto->id);
        if (!isset($episode)) {
            throw new NotFoundEpisode();
        }
        $this->setAttributes($episode, $changeEpisodeDto);
        $this->getEntityManager()->flush();

        return $this->episodeDtoMapper->fromModel($episode);
    }

    /**
     * @throws NotFoundCharacter
     */
    public function updateOrCreate(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto
    {
        $episode = $this->find($updateEpisodeDto->id);
        if (!isset($episode)) {
            $episode = new Episode();
        }
        $this->setAttributes($episode, $updateEpisodeDto);
        $this->getEntityManager()->flush();

        return $this->episodeDtoMapper->fromModel($episode);
    }

    /**
     * @throws NotFoundCharacter
     */
    private function setAttributes(
        Episode $episode,
        UpdateEpisodeDto|ChangeEpisodeDto|CreateEpisodeDto $episodeDto
    ): void {
        if (isset($episodeDto->name)) {
            $episode->setName($episodeDto->name);
        }
        if (isset($episodeDto->airDate)) {
            $episode->setAirDate(\DateTime::createFromFormat('Y-m-d', $episodeDto->airDate));
        }
        if (isset($episodeDto->code)) {
            $episode->setCode($episodeDto->code);
        }
        if (isset($episodeDto->characterIds)) {
            $existingCharacterIds = $episode->getCharacters()->map(function ($character) {
                return $character->getId();
            })->toArray();

            $characterIdsToAdd = array_diff($episodeDto->characterIds, $existingCharacterIds);
            $characterIdsToRemove = array_diff($existingCharacterIds, $episodeDto->characterIds);

            $characterRepository = $this->getEntityManager()->getRepository(Character::class);

            foreach ($characterIdsToAdd as $characterId) {
                $character = $characterRepository->find($characterId);
                if (!isset($character)) {
                    throw new NotFoundCharacter();
                }
                $episode->addCharacter($character);
            }

            foreach ($characterIdsToRemove as $characterId) {
                $character = $characterRepository->find($characterId);
                if (!isset($character)) {
                    throw new NotFoundCharacter();
                }
                $episode->removeCharacter($character);
            }
        }
    }
}

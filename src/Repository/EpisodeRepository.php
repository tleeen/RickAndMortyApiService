<?php

namespace App\Repository;

use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Managers\PaginatorManager;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Episode>
 */
class EpisodeRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginatorManager $paginatorManager
    )
    {
        parent::__construct($registry, Episode::class);
    }

    /**
     * @param GetEpisodesDto $getEpisodeDto
     * @return PaginateDto
     */
    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto
    {
        $ids = $getEpisodeDto->ids ? ['id' => $getEpisodeDto->ids] : [];

        $episodes = !empty($ids) ? $this->createQueryBuilder('episode')
            ->andWhere('location.id IN (:ids)')
            ->setParameter('ids', $ids) : $this->createQueryBuilder('episode');

        return EpisodeDto::fromPaginator($this
            ->paginatorManager
            ->paginate($episodes, $getEpisodeDto->page ?: 1));
    }

    /**
     * @param int $id
     * @return EpisodeDto
     */
    public function findById(int $id): EpisodeDto
    {
        return EpisodeDto::fromModel($this->find($id));
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
     * @param CreateEpisodeDto $createEpisodeDto
     * @return EpisodeDto
     */
    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto
    {
        $episode = new Episode();

        $episode->setName($createEpisodeDto->name);
        $episode->setAirDate(DateTime::createFromFormat('Y-m-d', $createEpisodeDto->airDate));
        $episode->setCode($createEpisodeDto->code);

        $this->getEntityManager()->persist($episode);
        $this->getEntityManager()->flush();

        return EpisodeDto::fromModel($episode);
    }

    /**
     * @param UpdateEpisodeDto $updateEpisodeDto
     * @return EpisodeDto
     */
    public function change(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto
    {
        /** @var Episode $episode */
        $episode = $this->find($updateEpisodeDto->id);

        if ($updateEpisodeDto->name) {
            $episode->setName($updateEpisodeDto->name);
        }
        if ($updateEpisodeDto->airDate) {
            $episode->setAirDate(DateTime::createFromFormat('Y-m-d', $updateEpisodeDto->airDate));
        }
        if ($updateEpisodeDto->code) {
            $episode->setCode($updateEpisodeDto->code);
        }

        $this->getEntityManager()->flush();

        return EpisodeDto::fromModel($episode);
    }
}

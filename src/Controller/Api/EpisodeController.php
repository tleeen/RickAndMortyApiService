<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Episode\EpisodeRepositoryInterface;
use App\Exceptions\Validation\ValidateException;
use App\Utils\Mappers\In\Episode\ChangeEpisodeDtoMapper;
use App\Utils\Mappers\In\Episode\CreateEpisodeDtoMapper;
use App\Utils\Mappers\In\Episode\GetEpisodesDtoMapper;
use App\Utils\Mappers\In\Episode\UpdateEpisodeDtoMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/episode', name: 'episode_')]
class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly EpisodeRepositoryInterface $episodeRepository,
        private readonly ValidateManagerInterface   $validateManager,
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/', name: "get", methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getEpisodesDto = GetEpisodesDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($getEpisodesDto);
            return new JsonResponse($this->episodeRepository->findMany($getEpisodesDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: "index", methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->episodeRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->episodeRepository->delete($id);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createEpisodeDto = CreateEpisodeDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($createEpisodeDto);
            return new JsonResponse($this->episodeRepository->create($createEpisodeDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['PATCH'])]
    public function change(Request $request): JsonResponse
    {
        $changeEpisodeDto = ChangeEpisodeDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($changeEpisodeDto);
            return new JsonResponse($this->episodeRepository->change($changeEpisodeDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $updateEpisodeDto= UpdateEpisodeDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($updateEpisodeDto);
            return new JsonResponse($this->episodeRepository->updateOrCreate($updateEpisodeDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }
}

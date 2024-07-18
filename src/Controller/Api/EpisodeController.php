<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Mappers\In\Episode\ChangeEpisodeDtoMapperInterface;
use App\Contracts\Mappers\In\Episode\CreateEpisodeDtoMapperInterface;
use App\Contracts\Mappers\In\Episode\GetEpisodesDtoMapperInterface;
use App\Contracts\Mappers\In\Episode\UpdateEpisodeDtoMapperInterface;
use App\Contracts\Repositories\Episode\EpisodeRepositoryInterface;
use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateInfoDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/episode', name: 'episode_')]
class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly EpisodeRepositoryInterface $episodeRepository,
        private readonly ValidateManagerInterface $validateManager,
        private readonly GetEpisodesDtoMapperInterface $getEpisodesDtoMapper,
        private readonly CreateEpisodeDtoMapperInterface $createEpisodeDtoMapper,
        private readonly ChangeEpisodeDtoMapperInterface $changeEpisodeDtoMapper,
        private readonly UpdateEpisodeDtoMapperInterface $updateEpisodeDtoMapper
    ) {
    }

    #[Route(name: 'get', methods: ['GET'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\Parameter(
        name: 'ids',
        in: 'query',
        schema: new OA\Schema(type: 'array[number]')
    )]
    #[OA\Parameter(
        name: 'page',
        in: 'query',
        schema: new OA\Schema(type: 'number')
    )]
    #[OA\Parameter(
        name: 'name',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'code',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'info',
                    ref: new Model(type: PaginateInfoDto::class),
                ),
                new OA\Property(
                    property: 'results',
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: EpisodeDto::class)),
                ),
            ],
            type: 'object')
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid data',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'name',
                    type: 'string',
                    example: 'Object(App\\DTO\\In\\Episode\\GetEpisodesDto).filters.code: This value is not valid.'
                ),
            ],
            type: 'object')
    )]
    public function getMany(Request $request): JsonResponse
    {
        $getEpisodesDto = $this->getEpisodesDtoMapper->fromRequest($request);
        $this->validateManager->validate($getEpisodesDto);

        return new JsonResponse($this->episodeRepository->findMany($getEpisodesDto));
    }

    #[Route('/{id}', name: 'index', methods: ['GET'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        schema: new OA\Schema(type: 'number')
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: EpisodeDto::class),
    )]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->episodeRepository->findById($id));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        schema: new OA\Schema(type: 'number')
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
    )]
    public function delete(int $id): JsonResponse
    {
        $this->episodeRepository->delete($id);

        return new JsonResponse();
    }

    #[Route(methods: ['POST'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateEpisodeDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: EpisodeDto::class),
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid data',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'name',
                    type: 'string',
                    example: 'Object(App\\DTO\\In\\Episode\\GetEpisodesDto).filters.code: This value is not valid.'
                ),
            ],
            type: 'object')
    )]
    public function create(Request $request): JsonResponse
    {
        $createEpisodeDto = $this->createEpisodeDtoMapper->fromRequest($request);
        $this->validateManager->validate($createEpisodeDto);

        return new JsonResponse($this->episodeRepository->create($createEpisodeDto));
    }

    #[Route('/{id}', methods: ['PATCH'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: ChangeEpisodeDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: EpisodeDto::class),
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid data',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'name',
                    type: 'string',
                    example: 'Object(App\\DTO\\In\\Episode\\GetEpisodesDto).filters.code: This value is not valid.'
                ),
            ],
            type: 'object')
    )]
    public function change(Request $request): JsonResponse
    {
        $changeEpisodeDto = $this->changeEpisodeDtoMapper->fromRequest($request);
        $this->validateManager->validate($changeEpisodeDto);

        return new JsonResponse($this->episodeRepository->change($changeEpisodeDto));
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[OA\Tag(name: 'Episodes')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateEpisodeDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: EpisodeDto::class),
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid data',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'name',
                    type: 'string',
                    example: 'Object(App\\DTO\\In\\Episode\\GetEpisodesDto).filters.code: This value is not valid.'
                ),
            ],
            type: 'object')
    )]
    public function update(Request $request): JsonResponse
    {
        $updateEpisodeDto = $this->updateEpisodeDtoMapper->fromRequest($request);
        $this->validateManager->validate($updateEpisodeDto);

        return new JsonResponse($this->episodeRepository->updateOrCreate($updateEpisodeDto));
    }
}

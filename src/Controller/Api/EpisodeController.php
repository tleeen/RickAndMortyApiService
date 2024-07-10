<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Episode\EpisodeRepositoryInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateInfoDto;
use App\Exceptions\Validation\ValidateException;
use App\Utils\Mappers\In\Episode\ChangeEpisodeDtoMapper;
use App\Utils\Mappers\In\Episode\CreateEpisodeDtoMapper;
use App\Utils\Mappers\In\Episode\GetEpisodesDtoMapper;
use App\Utils\Mappers\In\Episode\UpdateEpisodeDtoMapper;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;


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
    #[Route(name: "get", methods: ['GET'])]
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

    /**
     * @param int $id
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

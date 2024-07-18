<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Mappers\In\Location\ChangeLocationDtoMapperInterface;
use App\Contracts\Mappers\In\Location\CreateLocationDtoMapperInterface;
use App\Contracts\Mappers\In\Location\GetLocationsDtoMapperInterface;
use App\Contracts\Mappers\In\Location\UpdateLocationDtoMapperInterface;
use App\Contracts\Repositories\Location\LocationRepositoryInterface;
use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateInfoDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/location', name: 'location_')]
class LocationController extends AbstractController
{
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepository,
        private readonly ValidateManagerInterface    $validateManager,
        private readonly GetLocationsDtoMapperInterface $getLocationsDtoMapper,
        private readonly CreateLocationDtoMapperInterface $createLocationDtoMapper,
        private readonly ChangeLocationDtoMapperInterface $changeLocationDtoMapper,
        private readonly UpdateLocationDtoMapperInterface $updateLocationDtoMapper
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route(name: "get", methods: ['GET'])]
    #[OA\Tag(name: 'Locations')]
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
        name: 'type',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'dimension',
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
                    items: new OA\Items(ref: new Model(type: LocationDto::class)),
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
        $getLocationsDto = $this->getLocationsDtoMapper->fromRequest($request);
        $this->validateManager->validate($getLocationsDto);
        return new JsonResponse($this->locationRepository->findMany($getLocationsDto));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: "index", methods: ['GET'])]
    #[OA\Tag(name: 'Locations')]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        schema: new OA\Schema(type: 'number')
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: CharacterDto::class),
    )]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->locationRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[OA\Tag(name: 'Locations')]
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
        $this->locationRepository->delete($id);
        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route(methods: ['POST'])]
    #[OA\Tag(name: 'Locations')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateLocationDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: LocationDto::class),
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
        $createLocationDto = $this->createLocationDtoMapper->fromRequest($request);
        $this->validateManager->validate($createLocationDto);
        return new JsonResponse($this->locationRepository->create($createLocationDto));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['PATCH'])]
    #[OA\Tag(name: 'Locations')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: ChangeLocationDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: LocationDto::class),
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
        $changeLocationDto = $this->changeLocationDtoMapper->fromRequest($request);
        $this->validateManager->validate($changeLocationDto);
        return new JsonResponse($this->locationRepository->change($changeLocationDto));
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[OA\Tag(name: 'Locations')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateLocationDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: LocationDto::class),
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
        $updateLocationDto = $this->updateLocationDtoMapper->fromRequest($request);
        $this->validateManager->validate($updateLocationDto);
        return new JsonResponse($this->locationRepository->updateOrCreate($updateLocationDto));
    }
}

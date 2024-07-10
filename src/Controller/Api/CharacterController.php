<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateInfoDto;
use App\Exceptions\Validation\ValidateException;
use App\Utils\Mappers\In\Character\ChangeCharacterDtoMapper;
use App\Utils\Mappers\In\Character\CreateCharacterDtoMapper;
use App\Utils\Mappers\In\Character\GetCharactersDtoMapper;
use App\Utils\Mappers\In\Character\UpdateCharacterDtoMapper;
use Doctrine\ORM\Exception\ORMException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/character', name: 'character_')]
class CharacterController extends AbstractController
{
    public function __construct(
        private readonly CharacterRepositoryInterface $characterRepository,
        private readonly ValidateManagerInterface     $validateManager,
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route(name: 'get', methods: ['GET'])]
    #[OA\Tag(name: 'Characters')]
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
        name: 'status',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'species',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'type',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'gender',
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
                    items: new OA\Items(ref: new Model(type: CharacterDto::class)),
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
        $getCharactersDto = GetCharactersDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($getCharactersDto);
            return new JsonResponse($this->characterRepository->findMany($getCharactersDto));
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
    #[Route('/{id}', name: 'index', methods: ['GET'])]
    #[OA\Tag(name: 'Characters')]
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
        return new JsonResponse($this->characterRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['DELETE'])]
    #[OA\Tag(name: 'Characters')]
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
        $this->characterRepository->delete($id);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route(methods: ['POST'])]
    #[OA\Tag(name: 'Characters')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CreateCharacterDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: CharacterDto::class),
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
        $createCharacterDto = CreateCharacterDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($createCharacterDto);
            return new JsonResponse($this->characterRepository->create($createCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route('/{id}', methods: ['PATCH'])]
    #[OA\Tag(name: 'Characters')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: ChangeCharacterDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: CharacterDto::class),
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
        $changeCharacterDto = ChangeCharacterDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($changeCharacterDto);
            return new JsonResponse($this->characterRepository->change($changeCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route('/{id}', methods: ['PUT'])]
    #[OA\Tag(name: 'Characters')]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: UpdateCharacterDto::class)
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new Model(type: CharacterDto::class),
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
        $updateCharacterDto = UpdateCharacterDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($updateCharacterDto);
            return new JsonResponse($this->characterRepository->updateOrCreate($updateCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }
}

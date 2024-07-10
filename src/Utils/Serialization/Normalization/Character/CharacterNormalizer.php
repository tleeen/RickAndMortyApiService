<?php

namespace App\Utils\Serialization\Normalization\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\UpdateCharacterDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CharacterNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'name' => $object->name,
            'status' => $object->status,
            'species' => $object->species,
            'type' => $object->type,
            'gender' => $object->gender,
            'originId' => $object->originId,
            'locationId' => $object->locationId,
            'image' => $object->image,
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof CreateCharacterDto
            || $data instanceof ChangeCharacterDto
            || $data instanceof UpdateCharacterDto;
    }
}
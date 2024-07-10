<?php

namespace App\Utils\Serialization\Normalization\Location;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\UpdateLocationDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LocationNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'name' => $object->name,
            'type' => $object->type,
            'dimension' => $object->dimension,
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof CreateLocationDto
            || $data instanceof ChangeLocationDto
            || $data instanceof UpdateLocationDto;
    }
}
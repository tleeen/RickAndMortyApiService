<?php

namespace App\Utils\Serialization\Normalization\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EpisodeNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'name' => $object->name,
            'airDate' => $object->airDate,
            'code' => $object->code,
            'characterIds' => $object->characterIds,
        ];
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof CreateEpisodeDto
            || $data instanceof ChangeEpisodeDto
            || $data instanceof UpdateEpisodeDto;
    }
}
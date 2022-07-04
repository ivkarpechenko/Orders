<?php

namespace App\Serializer\Denormalizer;

use App\Dto\SetStatusDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SetStatusDtoDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): SetStatusDto
    {
        return new SetStatusDto($data["id"], $data["status"]);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === SetStatusDto::class;
    }
}
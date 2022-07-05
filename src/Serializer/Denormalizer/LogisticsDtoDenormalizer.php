<?php

namespace App\Serializer\Denormalizer;

use App\Dto\LogisticsDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class LogisticsDtoDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): LogisticsDto
    {
        return new LogisticsDto($data["id"], $data["orderId"], $data["price"], $data["name"]);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === LogisticsDto::class;
    }
}
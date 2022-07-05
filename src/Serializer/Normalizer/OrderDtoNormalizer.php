<?php

namespace App\Serializer\Normalizer;

use App\Dto\OrderDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OrderDtoNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object)) {
            return false;
        }
        return [
            'id' => $object->id,
            "status" => $object->status,
            "createdAt" => $object->createdAt,
            "logisticsId" => $object->logistics
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof OrderDto;
    }
}
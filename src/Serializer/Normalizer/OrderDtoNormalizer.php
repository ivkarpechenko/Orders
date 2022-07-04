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
            'id' => $object->getId(),
            "userName" => $object->getUserName(),
            "status" => $object->getStatus(),
            "createdAt" => $object->getCreatedAt()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof OrderDto;
    }
}
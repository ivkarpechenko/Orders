<?php

namespace App\Serializer\Normalizer;

use App\Dto\CreateOrderDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CreateOrderDtoNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object)) {
            return false;
        }
        return [
            'products' => $object
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof CreateOrderDto;
    }
}
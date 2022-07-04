<?php

namespace App\Serializer\Denormalizer;

use App\Dto\CreateOrderDto;
use App\Dto\ProductDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CreateOrderDtoDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): CreateOrderDto
    {
        $productsDto = [];
        foreach ($data["products"] as $product) {
            $productsDto[] = new ProductDto($product['id']);
        }
        return new CreateOrderDto($productsDto);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === CreateOrderDto::class;
    }
}
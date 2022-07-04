<?php

namespace App\Response;

use App\Dto\OrderDto;
use App\Serializer\Normalizer\OrderDtoNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class OrderResponse extends JsonResponse
{

    /**
     * @param OrderDto $dto
     * @throws ExceptionInterface
     */
    public function __construct(OrderDto $dto)
    {
        $normalizer = new OrderDtoNormalizer();
        $data = $normalizer->normalize($dto);
        parent::__construct($data, 200, []);
    }
}
<?php

namespace App\Serializer\Resolver;


use App\Dto\CreateOrderDto;
use App\Serializer\Denormalizer\CreateOrderDtoDenormalizer;
use App\Serializer\JsonDeserializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CreateOrderDtoResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === CreateOrderDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dto = (new JsonDeserializer([new CreateOrderDtoDenormalizer()]))->deserialize(
            $request->getContent(),
            CreateOrderDto::class
        );
        yield $dto;
    }
}
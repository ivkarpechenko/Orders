<?php

namespace App\Serializer\Resolver;

use App\Dto\LogisticsDto;
use App\Serializer\Denormalizer\LogisticsDtoDenormalizer;
use App\Serializer\JsonDeserializer;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpFoundation\Request;

class LogisticsDtoResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === LogisticsDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dto = (new JsonDeserializer([new LogisticsDtoDenormalizer()]))->deserialize(
            $request->getContent(),
            LogisticsDto::class
        );
        yield $dto;
    }
}
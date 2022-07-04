<?php

namespace App\Serializer\Resolver;


use App\Dto\SetStatusDto;
use App\Serializer\Denormalizer\SetStatusDtoDenormalizer;
use App\Serializer\JsonDeserializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SetStatusDtoResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === SetStatusDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dto = (new JsonDeserializer([new SetStatusDtoDenormalizer()]))->deserialize(
            $request->getContent(),
            SetStatusDto::class
        );
        yield $dto;
    }
}
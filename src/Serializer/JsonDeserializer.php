<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class JsonDeserializer
{
    private array $normalizers;
    private array $encoders;

    public function __construct(array $normalizers = [], array $encoders = [])
    {
        $this->normalizers = $normalizers;
        $this->encoders = array_merge($encoders, [
            new JsonEncoder(new JsonEncode()),
        ]);
    }

    public function deserialize($data, string $type)
    {
        if (empty($data)) {
            return new $type();
        }
        return (new Serializer($this->normalizers, $this->encoders))->deserialize($data, $type, 'json');
    }
}
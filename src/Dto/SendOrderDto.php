<?php

namespace App\Dto;

class SendOrderDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $volume,
        public readonly int $weight
    )
    {
    }
}
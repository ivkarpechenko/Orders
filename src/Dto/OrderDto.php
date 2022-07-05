<?php

namespace App\Dto;

class OrderDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly ?int $logistics
    )
    {
    }
}
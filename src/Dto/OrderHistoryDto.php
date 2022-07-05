<?php

namespace App\Dto;

class OrderHistoryDto
{
    public function __construct(
        public readonly string $status,
        public readonly string $createdAt
    )
    {
    }
}
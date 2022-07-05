<?php

namespace App\Dto;

class SetStatusDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $status
    )
    {
    }
}
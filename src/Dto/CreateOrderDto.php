<?php

namespace App\Dto;

class CreateOrderDto
{
    public function __construct(
        public readonly array $products
    )
    {
    }
}
<?php

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Entity\Order;

interface CreateOrderServiceInterface
{
    public function create(CreateOrderDto $dto): Order;
}
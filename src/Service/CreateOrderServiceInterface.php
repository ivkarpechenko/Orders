<?php

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Entity\Order;

interface CreateOrderServiceInterface
{
    public function create(CreateOrderDto $dto, string $userName): Order;

    public function saveInHistory(?Order $order): void;
}
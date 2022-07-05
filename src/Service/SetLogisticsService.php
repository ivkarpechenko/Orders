<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Repository\OrderRepository;

class SetLogisticsService implements SetLogisticsServiceInterface
{
    public function __construct(
        private OrderRepository $orderRepository
    )
    {
    }

    public function setLogistics(LogisticsDto $dto): void
    {
        $order = $this->orderRepository->find($dto->orderId);
        $order->change($dto->id,$dto->name,$dto->price);
    }
}
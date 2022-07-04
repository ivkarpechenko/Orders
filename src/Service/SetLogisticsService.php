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

    public function setLogistics(LogisticsDto $dto): int
    {
        $order = $this->orderRepository->find($dto->getIdOrder());
        $order->setLogisticsId($dto->getId());
        $order->setLogisticsName($dto->getName());
        $order->setPrice($dto->getPrice());
        return $order->getId();
    }
}
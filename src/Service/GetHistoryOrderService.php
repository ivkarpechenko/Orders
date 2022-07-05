<?php

namespace App\Service;

use App\Repository\OrderHistoryRepository;

class GetHistoryOrderService implements GetOrderHistoryServiceInterface
{
    public function __construct(
        private OrderHistoryRepository $orderHistoryRepository
    )
    {
    }

    public function getHistoryOrder(int $id): array
    {
        return $this->orderHistoryRepository->findBy(['orderId'=>$id]);
    }
}
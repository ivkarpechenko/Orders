<?php

namespace App\Service;

use App\Repository\OrderRepository;

class GetHistoryOrderService implements GetHistoryOrderServiceInterface
{
    public function __construct(
        private OrderRepository $orderRepository
    )
    {
    }

    public function getHistoryOrder(int $id): array
    {
        return $this->orderRepository->findHistoryById($id);
    }
}
<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderHistory;
use App\Repository\OrderHistoryRepository;

class SaveOrderHistoryService implements SaveOrderHistoryServiceInterface
{
    public function __construct(
        private OrderHistoryRepository $orderHistoryRepository
    )
    {
    }

    public function save(Order $order):OrderHistory
    {
        $orderHistory = new OrderHistory($order->getId(),$order->getStatus(), (new \DateTime())->format(DATE_ATOM));
        $this->orderHistoryRepository->add($orderHistory);
        return $orderHistory;
    }
}
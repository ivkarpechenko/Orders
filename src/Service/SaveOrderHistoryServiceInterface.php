<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderHistory;

interface SaveOrderHistoryServiceInterface
{
    public function save(Order $order): OrderHistory;
}
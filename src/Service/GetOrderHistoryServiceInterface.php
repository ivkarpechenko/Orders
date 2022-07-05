<?php

namespace App\Service;

interface GetOrderHistoryServiceInterface
{
    public function getHistoryOrder(int $id): array;
}
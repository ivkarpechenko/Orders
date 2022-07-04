<?php

namespace App\Service;

interface GetHistoryOrderServiceInterface
{
    public function getHistoryOrder(int $id): array;
}
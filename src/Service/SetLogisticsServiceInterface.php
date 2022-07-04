<?php

namespace App\Service;

use App\Dto\LogisticsDto;

interface SetLogisticsServiceInterface
{
    public function setLogistics(LogisticsDto $dto): int;
}
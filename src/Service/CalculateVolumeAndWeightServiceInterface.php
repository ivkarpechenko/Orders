<?php

namespace App\Service;

use App\Dto\SendOrderDto;

interface CalculateVolumeAndWeightServiceInterface
{
    public function calculate(int $id): SendOrderDto;
}
<?php

namespace App\Service;

use App\Dto\SetStatusDto;

interface SetStatusOrderServiceInterface
{
    public function setStatusOrder(SetStatusDto $dto): ?int;
}
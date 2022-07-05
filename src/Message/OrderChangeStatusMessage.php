<?php

namespace App\Message;

class OrderChangeStatusMessage
{
    public function __construct(
        public readonly int $id,
        public readonly string $status
    )
    {
    }
}
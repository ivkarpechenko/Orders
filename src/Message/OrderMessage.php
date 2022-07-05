<?php

namespace App\Message;

class OrderMessage
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}
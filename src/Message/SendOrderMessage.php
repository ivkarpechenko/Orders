<?php

namespace App\Message;

class SendOrderMessage
{
    public function __construct(
        public readonly int $id,
        public readonly int $volume,
        public readonly int $weight
    )
    {
    }
}
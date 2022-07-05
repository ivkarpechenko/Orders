<?php

namespace App\MessageHandler;

use App\Message\OrderMessage;
use App\Repository\OrderRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OrderMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private OrderRepository  $orderRepository,
        private ?LoggerInterface $logger = null
    )
    {
    }

    public function __invoke(OrderMessage $orderMessage)
    {
        $order = $this->orderRepository->find($orderMessage->id);
        $this->logger->info('Order change status', ['orderId' => $order->getId(), 'status' => $order->getStatus()]);
    }
}
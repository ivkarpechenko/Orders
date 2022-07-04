<?php

namespace App\MessageHandler;

use App\Message\OrderMessage;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

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
        $order = $this->orderRepository->find($orderMessage->getId());
        $this->logger->info('Order change status', ['orderId' => $orderMessage->getId(), 'status' => $order->getStatus()]);
    }
}
<?php

namespace App\MessageHandler;

use App\Entity\Order;
use App\Message\OrderChangeStatusMessage;
use App\Message\OrderMessage;
use App\Message\SendOrderMessage;
use App\Repository\OrderRepository;
use App\Service\CreateOrderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class OrderChangeStatusMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private OrderRepository             $orderRepository,
        private MessageBusInterface         $bus,
        private CreateOrderServiceInterface $createOrderService,
        private WorkflowInterface           $orderStateMachine,
        private ?LoggerInterface            $logger = null
    )
    {
    }

    public function __invoke(OrderChangeStatusMessage $orderChangeStatusMessage)
    {
        $order = $this->orderRepository->find($orderChangeStatusMessage->getId());
        if ($this->orderStateMachine->can($order, 'worked') && $orderChangeStatusMessage->getStatus() == "Processed") {
            $transition = 'worked';
            $this->saveInHistory($order, $transition);
            $this->bus->dispatch(new SendOrderMessage($order->getId(), $order->getSumVolume(), $order->getSumWeight()));

        } elseif ($this->orderStateMachine->can($order, 'to_transport') && $orderChangeStatusMessage->getStatus() == "Transferred to the transport company") {
            $transition = 'to_transport';
            $this->saveInHistory($order, $transition);
        } elseif ($this->orderStateMachine->can($order, 'complete') && $orderChangeStatusMessage->getStatus() == "Completed") {
            $transition = 'complete';
            $this->saveInHistory($order, $transition);
        } elseif ($this->orderStateMachine->can($order, 'cancel') && $orderChangeStatusMessage->getStatus() == "Canceled") {
            $transition = 'cancel';
            $this->saveInHistory($order, $transition);
        } elseif ($this->logger) {
            $this->logger->alert('Dropping order message', ['orderID' => $orderChangeStatusMessage->getId(), 'status' => $orderChangeStatusMessage->getStatus()]);
        }
    }

    public function saveInHistory(?Order $order, string $transition): void
    {
        $this->createOrderService->saveInHistory($order);
        $this->orderStateMachine->apply($order, $transition);
        $order->setCreatedAt(new \DateTime());
        $this->orderRepository->add($order);
        $this->entityManager->flush();
        $this->bus->dispatch(new OrderMessage($order->getId()));
    }
}
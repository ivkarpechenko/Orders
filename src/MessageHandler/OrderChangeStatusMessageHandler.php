<?php

namespace App\MessageHandler;

use App\Entity\Order;
use App\Message\OrderChangeStatusMessage;
use App\Message\OrderMessage;
use App\Message\SendOrderMessage;
use App\Repository\OrderRepository;
use App\Service\CalculateVolumeAndWeightServiceInterface;
use App\Service\SaveOrderHistoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class OrderChangeStatusMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface                   $entityManager,
        private OrderRepository                          $orderRepository,
        private MessageBusInterface                      $bus,
        private CalculateVolumeAndWeightServiceInterface $calculateVolumeAndWeightService,
        private SaveOrderHistoryServiceInterface         $saveOrderHistoryService,
        private WorkflowInterface                        $orderStateMachine,
        private ?LoggerInterface                         $logger = null
    )
    {
    }

    public function __invoke(OrderChangeStatusMessage $orderChangeStatusMessage)
    {
        $order = $this->orderRepository->find($orderChangeStatusMessage->id);
        if ($this->orderStateMachine->can($order, 'worked') && $orderChangeStatusMessage->status == "Processed") {
            $transition = 'worked';
            $this->saveInHistory($order, $transition);
            $sendOrderDto = $this->calculateVolumeAndWeightService->calculate($orderChangeStatusMessage->id);
            $this->bus->dispatch(new SendOrderMessage($sendOrderDto->id, $sendOrderDto->volume, $sendOrderDto->weight));

        } elseif ($this->orderStateMachine->can($order, 'to_transport') && $orderChangeStatusMessage->status == "Transferred to the transport company") {
            $transition = 'to_transport';
            $this->saveInHistory($order, $transition);
        } elseif ($this->orderStateMachine->can($order, 'complete') && $orderChangeStatusMessage->status == "Completed") {
            $transition = 'complete';
            $this->saveInHistory($order, $transition);
        } elseif ($this->orderStateMachine->can($order, 'cancel') && $orderChangeStatusMessage->status == "Canceled") {
            $transition = 'cancel';
            $this->saveInHistory($order, $transition);
        } elseif ($this->logger) {
            $this->logger->alert('Dropping order message', ['orderId' => $orderChangeStatusMessage->id, 'status' => $orderChangeStatusMessage->status]);
        }
    }

    public
    function saveInHistory(?Order $order, string $transition): void
    {
        $this->orderStateMachine->apply($order, $transition);
        $this->saveOrderHistoryService->save($order);
        $this->entityManager->flush();
        $this->bus->dispatch(new OrderMessage($order->getId()));
    }
}
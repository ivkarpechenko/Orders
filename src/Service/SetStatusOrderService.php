<?php

namespace App\Service;

use App\Dto\SetStatusDto;
use App\Message\OrderChangeStatusMessage;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class SetStatusOrderService implements SetStatusOrderServiceInterface
{
    public function __construct(
        private OrderRepository     $orderRepository,
        private WorkflowInterface   $orderStateMachine,
        private MessageBusInterface $bus
    )
    {
    }

    public function setStatusOrder(SetStatusDto $dto): ?int
    {
        $order = $this->orderRepository->find($dto->id);
        foreach ($this->orderStateMachine->getEnabledTransitions($order) as $enabledTransition) {
            foreach ($enabledTransition->getTos() as $to){
                if ($to == $dto->status) {
                    $this->bus->dispatch(new OrderChangeStatusMessage($dto->id, $dto->status));
                    return $dto->id;
                }
            }
        }
        return null;
    }
}
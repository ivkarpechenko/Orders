<?php

namespace App\Controller;

use App\Dto\CreateOrderDto;
use App\Dto\LogisticsDto;
use App\Dto\OrderDto;
use App\Dto\SetStatusDto;
use App\Message\OrderChangeStatusMessage;
use App\Message\OrderMessage;
use App\Response\OrderResponse;
use App\Serializer\JsonSerializer;
use App\Service\CreateOrderServiceInterface;
use App\Service\GetHistoryOrderServiceInterface;
use App\Service\SetLogisticsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class OrderController extends AbstractController
{

    public function __construct(
        private CreateOrderServiceInterface     $orderService,
        private GetHistoryOrderServiceInterface $getHistoryOrderService,
        private SetLogisticsServiceInterface    $setLogisticsService,
        private EntityManagerInterface          $entityManager,
        private MessageBusInterface             $bus
    )
    {
    }

    public function createOrder(CreateOrderDto $dto, $username = "userName"): OrderResponse
    {
        $order = $this->orderService->create($dto, $username);
        $this->entityManager->flush();
        $this->bus->dispatch(new OrderMessage($order->getId()));
        return new OrderResponse(new OrderDto($order->getId(), $order->getUserName(), $order->getStatus(), $order->getCreatedAt(), $order->getParentId()));
    }

    public function showHistoryOrder(int $id): JsonResponse
    {
        $orderHistory = $this->getHistoryOrderService->getHistoryOrder($id);
        $orders = [];
        foreach ($orderHistory as $order) {
            $orders[] = new OrderDto($order->getId(), $order->getUserName(), $order->getStatus(), $order->getCreatedAt(), $order->getLogisticsId());

        }
        $serializer = (new JsonSerializer([new ObjectNormalizer()]))->serialize($orders);
        return new JsonResponse($serializer, 200, [], true);
    }

    public function setStatusOrder(SetStatusDto $dto): JsonResponse
    {
        $this->bus->dispatch(new OrderChangeStatusMessage($dto->getId(), $dto->getStatus()));

        return new JsonResponse(["orderId" => $dto->getId()]);
    }

    public function setLogistics(LogisticsDto $dto): JsonResponse
    {
        $orderId = $this->setLogisticsService->setLogistics($dto);
        $this->entityManager->flush();
        $this->bus->dispatch(new OrderChangeStatusMessage($dto->getIdOrder(), "Transferred to the transport company"));
        return new JsonResponse(["orderId" => $orderId]);
    }
}

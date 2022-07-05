<?php

namespace App\Controller;

use App\Dto\CreateOrderDto;
use App\Dto\LogisticsDto;
use App\Dto\OrderDto;
use App\Dto\OrderHistoryDto;
use App\Dto\SetStatusDto;
use App\Message\OrderChangeStatusMessage;
use App\Message\OrderMessage;
use App\Response\OrderResponse;
use App\Serializer\JsonSerializer;
use App\Service\CreateOrderServiceInterface;
use App\Service\GetOrderHistoryServiceInterface;
use App\Service\SaveOrderHistoryService;
use App\Service\SetLogisticsServiceInterface;
use App\Service\SetStatusOrderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class OrderController extends AbstractController
{
    public function __construct(
        private CreateOrderServiceInterface     $orderService,
        private GetOrderHistoryServiceInterface $getOrderHistoryService,
        private SetLogisticsServiceInterface    $setLogisticsService,
        private SetStatusOrderServiceInterface  $setStatusOrderService,
        private SaveOrderHistoryService         $saveOrderHistoryService,
        private EntityManagerInterface          $entityManager,
        private MessageBusInterface             $bus
    )
    {
    }

    public function createOrder(CreateOrderDto $dto): OrderResponse
    {
        $order = $this->orderService->create($dto);
        $this->saveOrderHistoryService->save($order);
        $this->entityManager->flush();
        $this->bus->dispatch(new OrderMessage($order->getId()));
        return new OrderResponse(new OrderDto($order->getId(), $order->getStatus(), $order->getCreatedAt(), $order->getLogisticsId()));
    }

    public function showHistoryOrder(int $id): JsonResponse
    {
        $orderHistory = $this->getOrderHistoryService->getHistoryOrder($id);
        $orders = [];
        foreach ($orderHistory as $order) {
            $orders[] = new OrderHistoryDto($order->getStatus(), $order->getCreatedAt());
        }
        $serializer = (new JsonSerializer([new ObjectNormalizer()]))->serialize($orders);
        return new JsonResponse($serializer, 200, [], true);
    }

    public function setStatusOrder(SetStatusDto $dto): JsonResponse
    {
        $id = $this->setStatusOrderService->setStatusOrder($dto);
        return new JsonResponse(["orderId" => $id]);
    }

    public function setLogistics(LogisticsDto $dto): JsonResponse
    {
        $this->setLogisticsService->setLogistics($dto);
        $this->entityManager->flush();
        $id = $this->setStatusOrderService->setStatusOrder(new SetStatusDto($dto->orderId,"Transferred to the transport company"));
        return new JsonResponse(["orderId" => $id]);
    }
}

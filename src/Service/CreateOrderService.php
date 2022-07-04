<?php

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Dto\LogisticsDto;
use App\Dto\SetStatusDto;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Message\OrderMessage;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Workflow\WorkflowInterface;

class CreateOrderService implements CreateOrderServiceInterface
{

    public function __construct(
        private OrderRepository        $orderRepository,
        private OrderProductRepository $orderProductRepository,
        private ProductRepository      $productRepository
    )
    {
    }

    public function create(CreateOrderDto $dto, string $userName): Order
    {
        $order = new Order();
        $order->setUserName($userName);
        $order->setCreatedAt(new \DateTime());

        $sumVolume = 0;
        $sumWeight = 0;
        foreach ($dto->getProducts() as $product) {
            $product = $this->productRepository->findOneBy(["id" => $product->getId()]);
            $sumVolume += $product->getVolume();
            $sumWeight += $product->getWeight();
            $orderProduct = new OrderProduct($product, $order);
            $this->orderProductRepository->add($orderProduct);
        }

        $order->setSumVolume($sumVolume);
        $order->setSumWeight($sumWeight);
        $this->orderRepository->add($order);
        return $order;
    }

    public function saveInHistory(?Order $order): void
    {
        $oldStatusOrder = new Order();
        $oldStatusOrder->setParentId($order->getId());
        $oldStatusOrder->setUserName($order->getUserName());
        $oldStatusOrder->setStatus($order->getStatus());
        $oldStatusOrder->setCreatedAt($order->getCreatedAt());
        $this->orderRepository->add($oldStatusOrder);
    }
}
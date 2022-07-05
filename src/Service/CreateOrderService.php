<?php

namespace App\Service;

use App\Dto\CreateOrderDto;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;

class CreateOrderService implements CreateOrderServiceInterface
{
    public function __construct(
        private OrderRepository        $orderRepository,
        private OrderProductRepository $orderProductRepository,
        private ProductRepository      $productRepository
    )
    {
    }

    public function create(CreateOrderDto $dto): Order
    {
        $order = new Order((new \DateTime())->format(DATE_ATOM));
        foreach ($dto->products as $product) {
            $product = $this->productRepository->findOneBy(["id" => $product->id]);
            $orderProduct = new OrderProduct($product, $order);
            $this->orderProductRepository->add($orderProduct);
        }
        $this->orderRepository->add($order);
        return $order;
    }
}
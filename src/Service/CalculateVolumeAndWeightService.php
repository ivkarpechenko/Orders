<?php

namespace App\Service;

use App\Dto\SendOrderDto;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;

class CalculateVolumeAndWeightService implements CalculateVolumeAndWeightServiceInterface
{
    public function __construct(
        private OrderRepository        $orderRepository,
        private OrderProductRepository $orderProductRepository
    )
    {
    }

    public function calculate(int $id): SendOrderDto
    {
        $order = $this->orderRepository->find($id);
        $orderProducts = $this->orderProductRepository->findBy(['orderRef'=>$order]);
        $sumVolume = 0;
        $sumWeight = 0;
        foreach ($orderProducts as $orderProduct) {
            $sumVolume += $orderProduct->getProduct()->getVolume();
            $sumWeight += $orderProduct->getProduct()->getWeight();
        }
        return new SendOrderDto($id,$sumVolume,$sumWeight);
    }
}
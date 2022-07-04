<?php

namespace App\Dto;

class LogisticsDto
{
    public int $id;
    public int $idOrder;
    public int $price;
    public string $name;

    /**
     * @param int $id
     * @param int $idOrder
     * @param int $price
     * @param string $name
     */
    public function __construct(int $id, int $idOrder, int $price, string $name)
    {
        $this->id = $id;
        $this->idOrder = $idOrder;
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdOrder(): int
    {
        return $this->idOrder;
    }

    /**
     * @param int $idOrder
     */
    public function setIdOrder(int $idOrder): void
    {
        $this->idOrder = $idOrder;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
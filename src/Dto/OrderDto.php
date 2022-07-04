<?php

namespace App\Dto;

use DateTimeInterface;

class OrderDto
{
    private int $id;
    private string $userName;
    private string $status;
    private DateTimeInterface $createdAt;
    private ?int $logistics;

    /**
     * @param int $id
     * @param string $userName
     * @param string $status
     * @param DateTimeInterface $createdAt
     */
    public function __construct(int $id, string $userName, string $status, DateTimeInterface $createdAt, ?int $logistics)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->logistics = $logistics;
    }

    /**
     * @return int
     */
    public function getLogistics(): int
    {
        return $this->logistics;
    }

    /**
     * @param ?int $logistics
     */
    public function setLogistics(?int $logistics): void
    {
        $this->logistics = $logistics;
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
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}
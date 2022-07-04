<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $userName;

    #[ORM\Column(type: 'string', length: 255, options:["default" => 'Создан'])]
    private $status = "Created";

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'orderRef', targetEntity: OrderProduct::class)]
    private $orderProducts;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $parentId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $logisticsId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $sumVolume;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $sumWeight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logisticsName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $price;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setOrderRef($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrderRef() === $this) {
                $orderProduct->setOrderRef(null);
            }
        }

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getLogisticsId(): ?int
    {
        return $this->logisticsId;
    }

    public function setLogisticsId(?int $logisticsId): self
    {
        $this->logisticsId = $logisticsId;

        return $this;
    }

    public function getSumVolume(): ?int
    {
        return $this->sumVolume;
    }

    public function setSumVolume(?int $sumVolume): self
    {
        $this->sumVolume = $sumVolume;

        return $this;
    }

    public function getSumWeight(): ?int
    {
        return $this->sumWeight;
    }

    public function setSumWeight(?int $sumWeight): self
    {
        $this->sumWeight = $sumWeight;

        return $this;
    }

    public function getLogisticsName(): ?string
    {
        return $this->logisticsName;
    }

    public function setLogisticsName(?string $logisticsName): self
    {
        $this->logisticsName = $logisticsName;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}

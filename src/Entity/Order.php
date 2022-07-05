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

    #[ORM\Column(type: 'string', length: 255, options: ["default" => 'Created'])]
    private $status = "Created";

    #[ORM\Column(type: 'string', length: 255)]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'orderRef', targetEntity: OrderProduct::class)]
    private $orderProducts;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $logisticsId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $companyName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $price;

    public function __construct($createdAt)
    {
        $this->createdAt = $createdAt;
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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

    public function getLogisticsId(): ?int
    {
        return $this->logisticsId;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function change(int $logisticsId, string $companyName, int $price)
    {
        $this->logisticsId = $logisticsId;
        $this->companyName = $companyName;
        $this->price = $price;
    }
}

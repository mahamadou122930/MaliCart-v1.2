<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = self::STATUS_CART;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'myOrder', targetEntity: OrderItem::class, cascade: ["persist", "remove"], orphanRemoval:true)]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $carrierName = null;

    #[ORM\Column(length: 255)]
    private ?float $carrierPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?int $state = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }


    /**
     * An order that is in progress, not placed yet.
     * 
     * @var string
     */
    public const STATUS_CART = 'cart';


    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
        {
            foreach ($this->getOrderItems() as $existItem) {
                // The Item already exists, update the quantity
                if ($existItem->verif($orderItem)) {
                    $existItem->setQuantity(
                        $existItem->getQuantity() + $orderItem->getQuantity()
                    );

                    return $this;
                }
            }

            $this->orderItems[] = $orderItem;
            $orderItem->setMyOrder($this);

            return $this;
        }


    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getMyOrder() === $this) {
                $orderItem->setMyOrder(null);
            }
        }

        return $this;
    }

        /**
         * Removes all items from the order.
         * 
         * @return $this
         */
        public function removeOrderItems(): self
        {
            foreach ($this->getOrderItems() as $orderItem) {
                $this->removeOrderItem($orderItem);
            }
            return $this;
        }

    /**
     * Calculates the order total.
     */
    public function getTotaux(): float
    {
        $total = 0;

        foreach ($this->getOrderItems() as $orderItem) {
            $total += $orderItem->getTotaux();
        }

        return $total;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): static
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?string
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(string $carrierPrice): static
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;

        return $this;
    }
    
   
}

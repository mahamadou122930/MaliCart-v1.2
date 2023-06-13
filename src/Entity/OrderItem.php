<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShopProduct $shopproduct = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $myOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopproduct(): ?ShopProduct
    {
        return $this->shopproduct;
    }

    public function setShopproduct(?ShopProduct $shopproduct): self
    {
        $this->shopproduct = $shopproduct;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }


    public function getMyOrder(): ?Order
    {
        return $this->myOrder;
    }

    public function setMyOrder(?Order $myOrder): self
    {
        $this->myOrder = $myOrder;

        return $this;
    }


    /**
     * Test if the given item given corresponds to the same order item.
     */
    public function verif(OrderItem $myOrder): bool
    {
        $currentShopProduct = $this->getShopproduct();
        $comparaisonShopProduct = $myOrder->getShopproduct();

        return $currentShopProduct->getId() === $comparaisonShopProduct->getId()
            && $this->getSize() === $myOrder->getSize()
            && $this->getColor() === $myOrder->getColor();
    }

    /**
     * Calculates the items total.
     * 
     * @return float|int
     */
    public function getTotaux(): float
    {
        return $this->getShopproduct()->getPrice() * $this->getQuantity();
    }

    

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }
}   

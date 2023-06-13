<?php

namespace App\Entity;

use App\Repository\ShopProductSubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopProductSubCategoryRepository::class)]
class ShopProductSubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ShopProductCategory::class, mappedBy: 'SubCategory')]
    private Collection $shopProductCategories;

    #[ORM\OneToMany(mappedBy: 'SubCategory', targetEntity: ShopProduct::class)]
    private Collection $shopProducts;

    public function __construct()
    {
        $this->shopProductCategories = new ArrayCollection();
        $this->shopProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * @return Collection<int, ShopProductCategory>
     */
    public function getShopProductCategories(): Collection
    {
        return $this->shopProductCategories;
    }

    public function addShopProductCategory(ShopProductCategory $shopProductCategory): self
    {
        if (!$this->shopProductCategories->contains($shopProductCategory)) {
            $this->shopProductCategories->add($shopProductCategory);
            $shopProductCategory->addSubCategory($this);
        }

        return $this;
    }

    public function removeShopProductCategory(ShopProductCategory $shopProductCategory): self
    {
        if ($this->shopProductCategories->removeElement($shopProductCategory)) {
            $shopProductCategory->removeSubCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ShopProduct>
     */
    public function getShopProducts(): Collection
    {
        return $this->shopProducts;
    }

    public function addShopProduct(ShopProduct $shopProduct): self
    {
        if (!$this->shopProducts->contains($shopProduct)) {
            $this->shopProducts->add($shopProduct);
            $shopProduct->setSubCategory($this);
        }

        return $this;
    }

    public function removeShopProduct(ShopProduct $shopProduct): self
    {
        if ($this->shopProducts->removeElement($shopProduct)) {
            // set the owning side to null (unless already changed)
            if ($shopProduct->getSubCategory() === $this) {
                $shopProduct->setSubCategory(null);
            }
        }

        return $this;
    }

}

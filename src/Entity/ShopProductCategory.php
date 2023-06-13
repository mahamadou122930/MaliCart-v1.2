<?php

namespace App\Entity;

use App\Repository\ShopProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopProductCategoryRepository::class)]
class ShopProductCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: ShopProductSubCategory::class, inversedBy: 'shopProductCategories')]
    private Collection $SubCategory;

    public function __construct()
    {
        $this->SubCategory = new ArrayCollection();
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
     * @return Collection<int, ShopProductSubCategory>
     */
    public function getSubCategory(): Collection
    {
        return $this->SubCategory;
    }

    public function addSubCategory(ShopProductSubCategory $subCategory): self
    {
        if (!$this->SubCategory->contains($subCategory)) {
            $this->SubCategory->add($subCategory);
        }

        return $this;
    }

    public function removeSubCategory(ShopProductSubCategory $subCategory): self
    {
        $this->SubCategory->removeElement($subCategory);

        return $this;
    }
}

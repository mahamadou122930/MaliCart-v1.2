<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\ShopProduct;
use App\Entity\ShopProductColor;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderFactory
 */
class OrderFactory
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Creates an order.
     */
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    public function createItem(ShopProduct $shopProduct, Request $request): OrderItem
    {
        // Rechercher les OrderItems associés au même ShopProduct dans la commande
        $orderItems = $this->getMyOrder()->getOrderItems();
        
        foreach ($orderItems as $orderItem) {
            if ($orderItem->verif($shopProduct, $request)) {
                // Si un OrderItem correspondant est trouvé, incrémente simplement sa quantité
                $orderItem->setQuantity($orderItem->getQuantity() + 1);
                return $orderItem;
            }
        }
        
        // Si aucun OrderItem correspondant n'est trouvé, créer un nouvel OrderItem
        $orderItem = new OrderItem();
        $orderItem->setShopProduct($shopProduct);
        $orderItem->setQuantity(1);
        
        // Récupérer les paramètres de la couleur et de la taille
        $colorId = $request->request->get('color');
        // Récupérer l'entité Color correspondante à partir de la base de données
        $color = $this->entityManager->getRepository(ShopProductColor::class)->find($colorId);

        if ($color) {
            // Récupérer le nom de la couleur
            $colorName = $color->getName();

            // Définir la couleur sur l'OrderItem
            $orderItem->setColor($colorName);
        }
        
        $size = $request->request->get('size');
        
        // Définir la taille sur l'OrderItem
        $orderItem->setSize($size);
        
        return $orderItem;
    }
}
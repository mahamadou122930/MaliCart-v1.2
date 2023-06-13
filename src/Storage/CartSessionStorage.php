<?php

namespace App\Storage;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSessionStorage
{
    /**
     * The request stack.
     * 
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    public const CART_KEY_NAME = 'cart';

    /**
     * CartSessionStorage constructor.
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Gets the cart from the session.
     */
    public function getCart(): ?Order
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    /**
     * Sets the cart in the session.
     */
    public function setCart(Order $cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart);
    }

    /**
     * Removes the cart from the session.
     */
    public function removeCart(): void
    {
        $this->getSession()->remove(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
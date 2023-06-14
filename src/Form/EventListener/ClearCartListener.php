<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use App\Storage\CartSessionStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearCartListener implements EventSubscriberInterface
{
    private $cartSessionStorage;

    public function __construct(CartSessionStorage $cartSessionStorage)
    {
        $this->cartSessionStorage = $cartSessionStorage;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    /**
     * Removes all items from the cart when the clear button is clicked.
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart instanceof Order) {
            return;
        }

        // Is the clear button clicked?
        if (!$form->get('clear')->isClicked()) {
            return;
        }

        // Clears the cart
        $cart->removeOrderItems();

        // Save the updated cart back to the session
        $this->cartSessionStorage->setCart($cart);
    }
}

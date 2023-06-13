<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use App\Storage\CartSessionStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RemoveCartItemListener implements EventSubscriberInterface
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
     * Removes items from the cart based on the data sent from the user.
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart instanceof Order) {
            return;
        }

        // Removes items from the cart
        foreach ($form->get('orderItems')->all() as $child) {
            if ($child->get('remove')->isClicked()) {
                $cart->removeOrderItem($child->getData());
                break;
            }
        }

        // Save the updated cart back to the session
        $this->cartSessionStorage->setCart($cart);
    }
}
<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearCartListener implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        $cart = $form->getData();

        if (!$cart instanceof Order) {
            return;
        }

        // Is the clear button clicked?
        if (!$form->get('clear')->isClicked()) {
            return;
        }

        

        // Clears the cart
        $cart->removeOrderItems();

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}

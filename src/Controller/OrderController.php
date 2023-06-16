<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderCarrierType;
use App\Form\OrderType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'order')]
    public function index(CartManager $cart, Request $request): Response
    {

       if (!$this->getUser()->getAddresses()->getValues())
       {
            return $this->redirectToRoute('account_address_add');
       }
        $form = $this->createForm(OrderType::class, null, [
            'user'=> $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }



        return $this->render('order/index.html.twig', [
            'form'=> $form->createView(),
            'cart'=> $cart->getCurrentCart()
        ]);
    }

    #[Route('/commande/checkout-shipping', name: 'order_shipping')]
    public function shipping(CartManager $cart, Request $request): Response
    {

        $form = $this->createForm(OrderCarrierType::class, null, [
            'user'=> $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }



        return $this->render('order/order_shipping.html.twig', [
            'form'=> $form->createView(),
            'cart'=> $cart->getCurrentCart()
        ]);
    }
}

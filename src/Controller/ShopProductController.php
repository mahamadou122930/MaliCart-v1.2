<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\ShopProduct;
use App\Entity\ShopProductColor;
use App\Form\AddToCartType;
use App\Form\SearchType;
use App\Manager\CartManager;
use App\Repository\ShopProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/shop/products', name: 'shop_products')]
    public function index(Request $request, ShopProductRepository $repository, PaginatorInterface $paginator): Response
    {
        $shopproducts = $this->entityManager->getRepository(ShopProduct::class)->findAll();

        $pagination = $paginator->paginate(
            $repository->paginationQuery(),
            $request->query->get('page', 1),
            30
        );

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        [$min, $max] = $repository->findMinMax($search);
        if ($form->isSubmitted() && $form->isValid()) {
            $shopproducts = $this->entityManager->getRepository(ShopProduct::class)->findWithSearch($search);
        }

        return $this->render('shop_product/index.html.twig', [
            'shopproducts'=> $shopproducts,
            'form'=> $form->createView(),
            'pagination'=> $pagination,
            'min'=> $min,
            'max'=> $max,
        ]);
    }


    #[Route('/shop/product/{slug}', name: 'shop_product')]
    public function show(ShopProduct $shopProduct, Request $request, CartManager $cartManager): Response
    {
        $form = $this->createForm(AddToCartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();
            $orderItem->setShopproduct($shopProduct);
            
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
            $orderItem->setSize($size);

            $cart = $cartManager->getCurrentCart();

            $cart
                ->addOrderItem($orderItem)
                ->setUpdatedAt(new \DateTime());
            
            $cartManager->save($cart);

            return $this->redirectToRoute('shop_product', ['slug' => $shopProduct->getSlug()]);
        }
        

        return $this->render('shop_product/show.html.twig', [
            'shopproduct'=> $shopProduct,
            'form'=> $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\SessionService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    public function __construct(
        private readonly SessionService $sessionService
    ) {
    }


    #[Route('/session/shopping-cart', name: 'session_get_shopping_cart', methods: ['GET'])]
    public function getShoppingCart(): Response
    {
        return $this->json($this->sessionService->getShoppingCart());
    }

    #[Route('/session/shopping-cart/{id}', name: 'session_add_item_to_shopping_cart', methods: ['POST'])]
    public function addItemToShoppingCart(?Product $product): Response
    {
        if ($product) {
            $this->sessionService->addItemToShoppingCart($product);
        }


        return $this->json($this->sessionService->getShoppingCart());
    }

    #[Route('/session/shopping-cart/{id}', name: 'session_remove_item_from_shopping_cart', methods: ['DELETE'])]
    public function removeItemFromShoppingCart(?Product $product): Response
    {
        if ($product) {
            $this->sessionService->removeItemFromShoppingCart($product);
        }


        return $this->json($this->sessionService->getShoppingCart());
    }
}

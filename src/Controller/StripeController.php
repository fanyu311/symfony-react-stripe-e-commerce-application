<?php

namespace App\Controller;

use App\Service\StripeService;
use App\Service\SessionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    public function __construct(
        private readonly StripeService $stripeService
    ) {
    }
    #[Route('/stripe/checkout-sessions', name: 'create_checkout_session', methods: ['POST'])]
    public function createCheckoutSession(SessionService $sessionService): Response
    {
        return $this->json([
            'url' => $this->stripeService->createCheckoutSession($sessionService->getShoppingCart())->url
        ]);
    }

    #[Route('/stripe/success', name: 'success', methods: ['GET'])]
    public function success(Request $request): Response
    {
        $sessionId = $request->query->getString('session_id');

        return $this->render('stripe/success.html.twig', [
            'amountTotal' => $this->stripeService->getCheckoutSession($sessionId)->amount_total
        ]);
    }
}

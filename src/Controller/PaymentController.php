<?php

namespace App\Controller;

use Stripe\StripeClient;
use App\Repository\MaisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function index(Request $request, SessionInterface $sessionInterface, MaisonRepository $maisonRepository): Response
    {
        if ($request->headers->get('referer') !== 'https://127.0.0.1:8000/cart') {
            return $this->redirectToRoute('cart_index');
        }

        $cart = $sessionInterface->get('cart'); // récupération du panier en session
        $stripeCart = []; // initialisation du panier pour Stripe

        foreach ($cart as $id => $quantity) { // transformation du panier session en panier Stripe
            $house = $maisonRepository->find($id);
            $stripeElement = [
                'amount' => $house->getPrice() * 100,
                'quantity' => $quantity,
                'currency' => 'EUR',
                'name' => $house->getTitle()
            ];
            $stripeCart[] = $stripeElement;
        }

        $stripe = new StripeClient('sk_test_51KWKlACik8H17WbJXvEZxtELMwOV4y1xavwfb9SiQ6uoUTOREe80Hnc3l4SDwd55d47qDlzRjmEEyzczzYwNE8CM00HDKb9xtO');

        $stripeSession = $stripe->checkout->sessions->create([
            'line_items' => $stripeCart,
            'mode' => 'payment',
            'success_url' => 'https://127.0.0.1:8000/payment/success',
            'cancel_url' => 'https://127.0.0.1:8000/payment/cancel',
            'payment_method_types' => ['card']
        ]);

        return $this->render('payment/index.html.twig', [
            'sessionId' => $stripeSession->id
        ]);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(Request $request, SessionInterface $sessionInterface): Response
    {
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }
        // générer une facture
        // envoyer un mail de confirmation de commande avec la facture en pièce-jointe
        $sessionInterface->remove('cart'); // vide le panier
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel(Request $request): Response
    {
        if ($request->headers->get('referer') !== 'https://checkout.stripe.com/') {
            return $this->redirectToRoute('cart_index');
        }
        return $this->render('payment/cancel.html.twig');
    }
}

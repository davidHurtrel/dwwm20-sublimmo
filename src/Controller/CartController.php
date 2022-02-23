<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Repository\MaisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $sessionInterface, MaisonRepository $maisonRepository): Response
    {
        $sessionCart = $sessionInterface->get('cart', []); // récupération du panier
        $cart = []; // initialisation du panier
        $total = 0; // initialisation du montant total
        foreach ($sessionCart as $id => $quantity) {
            $house = $maisonRepository->find($id);
            $element = [
                'product' => $house,
                'quantity' => $quantity
            ];
            $cart[] = $element; // array_push($cart, $element);
            $total += $house->getPrice() * $quantity;
        }
        $latestProducts = $maisonRepository->findBy([], ['id' => 'DESC'], 3);
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'latestProducts' => $latestProducts
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Maison $maison, SessionInterface $sessionInterface): Response
    {
        $cart = $sessionInterface->get('cart', []); // récupère le panier actuel
        $id = $maison->getId(); // récupère l'id de la maison à ajouter au panier
        if (!empty($cart[$id])) { // ajout au panier
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $sessionInterface->set('cart', $cart); // sauvegarde en session
        return $this->redirectToRoute('cart_index'); // redirection
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(SessionInterface $sessionInterface, Maison $maison): Response
    {
        $cart = $sessionInterface->get('cart', []);
        $id = $maison->getId();
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
        $sessionInterface->set('cart', $cart);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/delete/{id}', name: 'cart_delete')]
    public function delete(SessionInterface $sessionInterface, Maison $maison): Response
    {
        $cart = $sessionInterface->get('cart', []);
        $id = $maison->getId();
        if (!empty([$cart[$id]])) {
            unset($cart[$id]);
        }
        $sessionInterface->set('cart', $cart);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(SessionInterface $sessionInterface): Response
    {
        // $sessionInterface->clear(); // efface toute la session (y compris la connexion d'un user)
        // $sessionInterface->set('cart', null);
        $sessionInterface->remove('cart');
        return $this->redirectToRoute('cart_index');
    }
}

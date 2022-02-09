<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Form\MaisonType;
use App\Repository\MaisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MaisonController extends AbstractController
{
    #[Route('/maisons', name: 'maison_index')]
    public function index(MaisonRepository $maisonRepository): Response
    {
        $houses = $maisonRepository->findAll();
        return $this->render('maison/index.html.twig', [
            'maisons' => $houses,
        ]);
    }

    #[Route('/admin/maisons', name: 'admin_maison_index')]
    public function adminIndex(MaisonRepository $maisonRepository): Response
    {
        $houses = $maisonRepository->findAll();
        return $this->render('admin/maisons.html.twig', [
            'maisons' => $houses
        ]);
    }

    #[Route('/admin/maison/create', name: 'maison_create')]
    public function create(Request $request)
    {
        $maison = new Maison(); // création d'une nouvelle maison
        $form = $this->createForm(MaisonType::class, $maison); // création d'un formulaire avec en paramètre la nouvelle maison
        $form->handleRequest($request); // gestionnaire de requêtes HTTP

        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView()
        ]);
    }
}

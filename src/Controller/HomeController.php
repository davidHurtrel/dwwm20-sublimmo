<?php

namespace App\Controller;

use App\Repository\CommercialRepository;
use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(MaisonRepository $maisonRepository, CommercialRepository $commercialRepository): Response
    {
        // $houses = $maisonRepository->findAll(); // trouve toutes les maisons
        // $houses = $maisonRepository->findBy([], ['id' => 'DESC'], 6); // trouve les 6 dernières maisons
        $houses = $maisonRepository->findLastSix(); // queryBuilder
        // $houses = $maisonRepository->trouverDernierSix(); // SQL

        $commercials = $commercialRepository->findAll();

        return $this->render('home/index.html.twig', [
            'maisons' => $houses,
            'commerciaux' => $commercials
        ]);
    }
}

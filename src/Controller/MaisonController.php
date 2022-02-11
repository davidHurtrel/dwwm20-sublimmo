<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Form\MaisonType;
use App\Repository\MaisonRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $maison = new Maison(); // création d'une nouvelle maison
        $form = $this->createForm(MaisonType::class, $maison); // création d'un formulaire avec en paramètre la nouvelle maison
        $form->handleRequest($request); // gestionnaire de requêtes HTTP

        if ($form->isSubmitted() && $form->isValid()) { // vérifie si le formulaire a été envoyé et est valide

            $infoImg1 = $form['img1']->getData(); // récupère les informations de l'image 1
            $extensionImg1 = $infoImg1->guessExtension(); // récupère l'extension de l'image 1
            $nomImg1 = time() . '-1.' . $extensionImg1; // crée un nom unique pour l'image 1
            $infoImg1->move($this->getParameter('dossier_photos_maisons'), $nomImg1); // télécharge l'image dans le dossier adéquat
            $maison->setImg1($nomImg1); // définit le nom de l'iamge à mettre en bdd

            $infoImg2 = $form['img2']->getData();
            if ($infoImg2 !== null) {
                $extensionImg2 = $infoImg2->guessExtension();
                $nomImg2 = time() . '-2.' . $extensionImg2;
                $infoImg2->move($this->getParameter('dossier_photos_maisons'), $nomImg2);
                $maison->setImg2($nomImg2);
            } else {
                $maison->setImg2(null);
            }

            $manager = $managerRegistry->getManager();
            $manager->persist($maison);
            $manager->flush();

            // message de succes
            return $this->redirectToRoute('admin_maison_index');
        }

        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView()
        ]);
    }
}

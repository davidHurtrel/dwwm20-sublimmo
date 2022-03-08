<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Form\MaisonType;
use App\Form\MaisonSearchType;
use App\Repository\MaisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaisonController extends AbstractController
{
    #[Route('/maisons', name: 'maison_index')]
    public function index(MaisonRepository $maisonRepository, EntityManagerInterface $entityManagerInterface, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        // $houses = $maisonRepository->findAll();
        
        // avec pagination
        $dql = "SELECT a FROM App:Maison a";
        $query = $entityManagerInterface->createQuery($dql);
        $houses = $paginatorInterface->paginate($query, $request->query->getInt('page', 1), 4);
        
        return $this->render('maison/index.html.twig', [
            'maisons' => $houses,
        ]);
    }

    #[Route('/maison/{id}', name: 'maison_show')]
    public function show(MaisonRepository $maisonRepository, int $id): Response
    {
        $maison = $maisonRepository->find($id);
        if (empty($maison)) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
        return $this->render('maison/show.html.twig', [
            'maison' => $maison
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
            $this->addFlash('success', 'La maison a bien été ajoutée');
            return $this->redirectToRoute('admin_maison_index');
        }
        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView()
        ]);
    }

    #[Route('/admin/maison/update/{id}', name: 'maison_update')]
    public function update(MaisonRepository $maisonRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $maison = $maisonRepository->find($id);
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg1 = $form['img1']->getData();
            $nomOldImg1 = $maison->getImg1();
            if ($infoImg1 !== null) {
                $cheminOldImg1 = $this->getParameter('dossier_photos_maisons') . '/' . $nomOldImg1;
                if (file_exists($cheminOldImg1)) {
                    unlink($cheminOldImg1);
                }
                $extensionImg1 = $infoImg1->guessExtension();
                $nomImg1 = time() . '-1.' . $extensionImg1;
                $infoImg1->move($this->getParameter('dossier_photos_maisons'), $nomImg1);
                $maison->setImg1($nomImg1);
            } else {
                $maison->setImg1($nomOldImg1);
            }
            $infoImg2 = $form['img2']->getData();
            $nomOldImg2 = $maison->getImg2();
            if ($infoImg2 !== null) {
                if ($nomOldImg2 !== null) {
                    $cheminOldImg2 = $this->getParameter('dossier_photos_maisons') . '/' . $nomOldImg2;
                    if (file_exists($cheminOldImg2)) {
                        unlink($cheminOldImg2);
                    }
                }
                $extensionImg2 = $infoImg2->guessExtension();
                $nomImg2 = time() . '-2.' . $extensionImg2;
                $infoImg2->move($this->getParameter('dossier_photos_maisons'), $nomImg2);
                $maison->setImg2($nomImg2);
            } else {
                $maison->setImg2($nomOldImg2);
            }
            $manager = $managerRegistry->getManager();
            $manager->persist($maison);
            $manager->flush();
            $this->addFlash('success', 'La maison a bien été modifiée');
            return $this->redirectToRoute('admin_maison_index');
        }
            
        return $this->render('admin/maisonForm.html.twig', [
            'maisonForm' => $form->createView(),
            'maison' => $maison
        ]);
    }

    #[Route('/admin/maison/delete/{id}', name: 'maison_delete')]
    public function delete(MaisonRepository $maisonRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $maison = $maisonRepository->find($id); // récupère la maison grâce à son id
        $nomImg1 = $maison->getImg1(); // récupère le nom de l'image 1
        if ($nomImg1 !== null) { // vérifie qu'il y a bien un nom d'image (et donc une image à supprimer)
            $cheminImg1 = $this->getParameter('dossier_photos_maisons') . '/' . $nomImg1; // reconstitue le chemin de l'image
            if (file_exists($cheminImg1)) { // vérifie si le fichier existe
                unlink($cheminImg1); // supprime le fichier
            }
        }
        $nomImg2 = $maison->getImg2();
        if ($nomImg2 !== null) {
            $cheminImg2 = $this->getParameter('dossier_photos_maisons') . '/' . $nomImg2;
            if (file_exists($cheminImg2)) {
                unlink($cheminImg2);
            }
        }
        $manager = $managerRegistry->getManager();
        $manager->remove($maison);
        $manager->flush();
        $this->addFlash('success', 'La maison a bien été supprimée');
        return $this->redirectToRoute('admin_maison_index');
    }

    #[Route('/search', name: 'maison_search')]
    public function search(Request $request, MaisonRepository $maisonRepository): Response
    {
        $form = $this->createForm(MaisonSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rooms = $form['pieces']->getData();
            $bedrooms = $form['chambres']->getData();
            $surface = $form['surface']->getData();
            $budget = $form['budget']->getData();
            $houses = $maisonRepository->search($rooms, $bedrooms, $surface, $budget);
            return $this->render('maison/search.html.twig', [
                'searchForm' => $form->createView(),
                'maisons' => $houses
            ]);
        }

        return $this->render('maison/search.html.twig', [
            'searchForm' => $form->createView()
        ]);
    }
}

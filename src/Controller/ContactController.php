<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData(); // récupère les infos du formulaire
            $email = (new TemplatedEmail())
                ->from(new Address($contact['email'], $contact['prenom'] . ' ' . $contact['nom']))
                ->to(new Address('david.hurtrel@gmail.com'))
                ->subject('SUBL\'IMMO - demande de contact - ' . $contact['objet'])
                ->htmlTemplate('contact/contact_email.html.twig') // chemin du template twig
                ->context([ // passe les informations du formulaire au template
                    'prenom' => $contact['prenom'],
                    'nom' => $contact['nom'],
                    'adresseEmail' => $contact['email'],
                    'objet' => $contact['objet'],
                    'message' => $contact['message'],
                ]);
            if ($contact['fichier'] !== null) { // vérifie s'il y a un fichier dans le formulaire
                $originalFilename = pathinfo($contact['fichier']->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename); // nécessaire pour inclure le nom de fichier dans l'URL
                $newFilename = $safeFilename . '.' . $contact['fichier']->guessExtension();
                $email->attachFromPath($contact['fichier']->getPathName(), $newFilename); // attache la pièce-jointe au corps du mail
            }
            $mailer->send($email);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}

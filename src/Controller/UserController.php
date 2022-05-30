<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'admin_user_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/create', name: 'admin_user_create')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $managerRegistry): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $roles = $form['roles']->getData();
            if (in_array('ROLE_USER', $roles)) {
                unset($roles['ROLE_USER']);
            }
            $user->setRoles($roles);
            $managerRegistry->getManager()->persist($user);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/userForm.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}

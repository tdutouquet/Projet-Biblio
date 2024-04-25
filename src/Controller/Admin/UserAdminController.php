<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAdminController extends AbstractController
{
    #[Route('/admin/utilisateurs', name: 'app_user_admin')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user_admin/index.html.twig', [
            'controller_name' => 'UserAdminController',
            'users' => $users
        ]);
    }

    #[Route('/admin/utilisateurs/details/{id}', name: 'app_user_admin_details')]
    public function details(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository, int $id): Response
    {
        // Display the user
        $userDisplay = $user;

        // Handle the form
        $userForm = $this->createForm(UserFormType::class, $user);
        $userForm->handleRequest($request);        

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            dd($userForm->GetData());
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('app_user_admin');
        }

        return $this->render('admin/user_admin/details.html.twig', [
            'controller_name' => 'UserAdminDetailsController',
            'userDisplay' => $userDisplay,
            'userForm' => $userForm->createView(),
        ]);
    }

    #[Route('/admin/utilisateurs/ajouter', name: 'app_user_admin_add')]
    public function add(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $plaintextPassword = 'temp';

        $userForm = $this->createForm(UserFormType::class, $user);

        $userForm->handleRequest($request);
    
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute('app_user_admin');
        }

        return $this->render('admin/user_admin/add.html.twig', [
            'controller_name' => 'UserAdminAddController',
            'userForm' => $userForm->createView(),
        ]);
    }
}

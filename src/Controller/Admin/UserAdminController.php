<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function details(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        return $this->render('admin/user_admin/details.html.twig', [
            'controller_name' => 'UserAdminDetailsController',
            'user' => $user,
        ]);
    }

    #[Route('/admin/utilisateurs/ajouter', name: 'app_user_admin_add')]
    public function add(): Response
    {
        $user = new User();

        $userForm = $this->createForm(UserFormType::class, $user);

        return $this->render('admin/user_admin/add.html.twig', [
            'controller_name' => 'UserAdminAddController',
            'userForm' => $userForm->createView(),
        ]);
    }
}

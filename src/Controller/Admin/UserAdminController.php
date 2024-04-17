<?php

namespace App\Controller\Admin;

use App\Entity\User;
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

    #[Route('/admin/utilisateurs/{id}', name: 'app_user_admin_details')]
    public function details(UserRepository $userRepository, int $id, Request $request, User $userDb): Response
    {
        $user = $userRepository->find($id);

        return $this->render('admin/user_admin/details.html.twig', [
            'controller_name' => 'UserAdminController',
            'user' => $user,
        ]);
    }
}

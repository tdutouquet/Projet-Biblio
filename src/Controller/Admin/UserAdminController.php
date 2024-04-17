<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserAdminController extends AbstractController
{
    #[Route('/admin/utilisateurs', name: 'app_user_admin')]
    public function index(): Response
    {
        return $this->render('admin/user_admin/index.html.twig', [
            'controller_name' => 'UserAdminController',
        ]);
    }
}

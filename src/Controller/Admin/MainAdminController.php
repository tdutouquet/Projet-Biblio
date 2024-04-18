<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainAdminController extends AbstractController
{
    #[Route('/admin', name: 'app_main_admin')]
    public function index(): Response
    {
        return $this->render('admin/main_admin/index.html.twig', [
            'controller_name' => 'MainAdminController',
        ]);
    }
}

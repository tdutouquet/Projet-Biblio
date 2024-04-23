<?php

namespace App\Controller\Admin;

use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubAdminController extends AbstractController
{
    #[Route('/admin/abonnements', name: 'app_sub_admin')]
    public function index(SubscriptionRepository $subRepo): Response
    {
        $subs = $subRepo->findAll();

        return $this->render('admin/sub_admin/index.html.twig', [
            'controller_name' => 'SubAdminController',
            'subs' => $subs
        ]);
    }
}

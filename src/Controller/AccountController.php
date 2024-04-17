<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user
        ]);
    }

    #[Route('/compte/modifier', name: 'app_account_edit')]
    public function edit(): Response
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }
        return $this->render('account/edit.html.twig', [
            'controller_name' => 'AccountEditController',
            'user' => $user
        ]);
    }
}

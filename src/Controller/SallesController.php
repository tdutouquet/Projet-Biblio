<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SallesController extends AbstractController
{
    #[Route('/salles', name: 'app_salles')]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('salles/index.html.twig', [
            'controller_name' => 'SallesController',
        ]);
    }
}

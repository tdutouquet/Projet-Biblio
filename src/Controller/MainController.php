<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/livres-dispo', name: 'livres_dispos')]
    public function livresDispos(LivresRepository $livresRepository): Response
    {

        $livres = $livresRepository->findAll();

        return $this->render('_partials/livres_dispos.html.twig', [
            'livres' => $livres, 
        ]);
    }
}
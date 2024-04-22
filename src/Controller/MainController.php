<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/changer-langue/{_locale}', name: 'changer_langue')]
public function changerLangue(Request $request): Response
{
    // Récupérer la langue sélectionnée depuis la route
    // $locale = $request->getLocale();
    $locale = $request->get('_locale');

    // Stocker la langue sélectionnée dans la session
    $request->getSession()->set('_locale', $locale);

    // Rediriger l'utilisateur vers la page précédente ou la page d'accueil
    return $this->redirectToRoute('app_main');
}

}
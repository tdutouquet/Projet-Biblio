<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route("/changer_langue/{locale}", name: 'changer_langue')]
    public function changerLangue ($locale, Request $request)
    {
        // On stock la langue demandée dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
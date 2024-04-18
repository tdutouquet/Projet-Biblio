<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivresRepository;
use App\Entity\Livres;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class LivresController extends AbstractController
{
    // #[Route('/livres', name: 'app_livres')]
    // public function index(): Response
    // {
    //     return $this->render('livres/index.html.twig', [
    //         'controller_name' => 'LivresController',
    //     ]);
    // }

    #[Route('/livres', name: 'app_livres')]
    public function livresListe(LivresRepository $livresRepository): Response
    {

        $livres = $livresRepository->findAll();
        // faut chercher QUE les livres dispos à afficher

        return $this->render('livres/index.html.twig', [
            'livres' => $livres, 
        ]);
    }

    #[Route('/livres/{id}/reserve', name: 'app_livre_reserve')]
    public function reserveLivres(Request $request, Livres $livre, EntityManagerInterface $entityManager, LivresRepository $livresRepository): Response
    {
        // vérif si user est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Récup user connecté
        $user = $this->getUser();

        // récup id du livre
        // $livreId = $livresRepository->find($livreId);

        // vérif si livre existe
        if(!$livre){
            throw $this->createNotFoundException('Le livre n\'existe pas !');
        }

        // vérif si livre est disponible
        if($livre->isDisponibilite()){
            // user reserve le livre
            $livre->setReservePar($user);
            $livre->setDisponibilite(false); // livre est maintenant indisponible

            // enregistrement en bdd
            $entityManager->flush();

            // redirection vers la page détails du livre + msg succès
            return $this->redirectToRoute('app_livre_details', ['id' => $livre->getId()], Response::HTTP_SEE_OTHER);
        } else {
            // Redirection vers page d'accueil + msg d'erreur
            return $this->redirectToRoute('app_livres', [], Response::HTTP_SEE_OTHER);
        }
    }

}

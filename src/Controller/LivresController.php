<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Entity\Emprunt;
use App\Repository\LivresRepository;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function livresListe(LivresRepository $livresRepository, EmpruntRepository $empruntRepository): Response
    {

        $livres = $livresRepository->findAll();
        // faut chercher QUE les livres dispos à afficher

        $emprunts = $empruntRepository->findEnmprunt();
        // dd($emprunts);

        return $this->render('livres/index.html.twig', [
            'emprunts' => $emprunts,
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

            $dateDebut = new \DateTime();
            // clone  = pour cloner date de début dans autre objet car DateTime est un obj mutable, clone pour ne pas impacter sa variable de base
            $dateFin = (clone $dateDebut)->modify('+6 day');
            // dd($dateDebut, $dateFin);


            // créer nouvel emprunt
            $emprunt = new Emprunt();

            $emprunt->setLivres($livre);
            $emprunt->setUser($user);
            $emprunt->setDateDebut($dateDebut);
            $emprunt->setDateFin($dateFin);
            $emprunt->setExtension(false);

            // mettre à jour livre concerné par l'emprunt
            $livre->setDisponibilite(false); // livre est maintenant indisponible

            $entityManager->persist($emprunt);
            // enregistrement en bdd
            $entityManager->flush();

            // redirection vers la page des livres
            return $this->redirectToRoute('app_livres');
        } else {
            // Redirection vers page d'accueil + msg d'erreur
            return $this->redirectToRoute('app_livres', [], Response::HTTP_SEE_OTHER);
        }

    }

    #[Route('/livres/details/{id}', name: 'app_livres_details')]
    public function details(Livres $livre): Response
    {
        return $this->render('livres/details.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/admin/livres/non-restitues', name: 'app_livres_nonrestitue')]
    public function livresNonRestitue(): Response
    {
        $livresNonRestitues = $this->getDoctrine()->getRepository(Livres::class)->findLivresNonRestitues();

        return $this->render('admin_livres/nonrestitues.html.twig', [
            'livres' => $livresNonRestitues,
        ]);
    }

}

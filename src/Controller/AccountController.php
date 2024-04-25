<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\AccountFormType;
use App\Repository\CommentRepository;
use App\Repository\EmpruntRepository;
use App\Repository\RentalRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(UserInterface $user, SubscriptionRepository $subRepo, EmpruntRepository $empruntRepository, CommentRepository $comRepo, RentalRepository $rentalRepo): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }
        
        $sub = $subRepo->findOneBy(['user' => $user]);
        
        $historiqueEmprunts = $empruntRepository->findBy(
            ['user' => $user],
            ['id' => 'DESC']
        );
       
        $comments = $comRepo->findBy(
            ['user' => $user],
            ['id' => 'DESC']
        );

        $rentals = $rentalRepo->findBy(
            ['user' => $user],
            ['id' => 'DESC']
        );

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
            'historiqueEmprunts' => $historiqueEmprunts,
            'subscription' => $sub,
            'comments' => $comments,
            'rentals' => $rentals
        ]);
    }

    #[Route('/compte/modifier', name: 'app_account_edit')]
    public function edit(UserInterface $user, Request $request, EntityManagerInterface $em): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        $accountForm = $this->createForm(AccountFormType::class, $user);
        $accountForm->handleRequest($request);

        if ($accountForm->isSubmitted() && $accountForm->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre compte a bien été modifié');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'controller_name' => 'AccountEditController',
            'user' => $user,
            'accountForm' => $accountForm->createView()
        ]);
    }

    #[Route('/compte/extension/{id}', name: 'app_account_extension')]
    public function extension(int $id, EntityManagerInterface $entityManager): Response
    {
        $emprunt = $entityManager->getRepository(Emprunt::class)->find($id);

        // vérif si emprunt existe
        if (!$emprunt) {
            throw $this->createNotFoundException('Emprunt non trouvé.');
        }

        // vérif si user peut demander une extension
        if($emprunt->isExtension()) {
            // si extension a déjà été demandée
            $this->addFlash('warning', 'Une extension a déjà été demandée pour ce livre ? cet emprunt ?');
        } elseif (!$emprunt->isEligiblePourExtension()) {
            // si extension n'est pas possible
            $this->addFlash('warning', 'Extension impossible pour ce livre.');
        } else {
            // si user peut faire l'extension
            $emprunt->setExtension(true);
            $newDateFin = (clone $emprunt->getDateFin())->modify('+6 day');
            $emprunt->setDateFin($newDateFin);

            $entityManager->flush();

            $this->addFlash('success', 'Extension effectuee avec succès.');
        }
    }

}

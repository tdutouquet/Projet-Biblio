<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\AccountFormType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(UserInterface $user, SubscriptionRepository $subRepo, EmpruntRepository $empruntRepository, TranslatorInterface $translator): Response
    {
        if (!$user) {
            $message = $translator->trans('Utilisateur non connecté');
            throw $this->createNotFoundException($message);
        }

        $sub = $subRepo->findOneBy(['user' => $user]);
        // $emp = $empRepo->findBy(['user' => $user]);

        // $emprunts = $empRepo->findEmpruntsWithDetailsByUser($user);

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
            'historiqueEmprunts' => $historiqueEmprunts,
            'subscription' => $sub,
            // 'emprunts' => $emprunts,
        ]);
    }

    #[Route('/compte/modifier', name: 'app_account_edit')]
    public function edit(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $message = $translator->trans('Utilisateur non connecté');
            throw $this->createNotFoundException($message);
        }

        $accountForm = $this->createForm(AccountFormType::class, $user);
        $accountForm->handleRequest($request);

        if ($accountForm->isSubmitted() && $accountForm->isValid()) {
            $em->persist($user);
            $em->flush();

            $message = $translator->trans('Votre compte a bien été modifié');
            $this->addFlash('success', $message );
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'controller_name' => 'AccountEditController',
            'user' => $user,
            'accountForm' => $accountForm->createView()
        ]);
    }

    #[Route('/compte/extension/{id}', name: 'app_account_extension')]
    public function extension(int $id, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $emprunt = $entityManager->getRepository(Emprunt::class)->find($id);

        // vérif si emprunt existe
        if (!$emprunt) {
            $message = $translator->trans('Emprunt non trouvé.');
            throw $this->createNotFoundException($message);
        }

        // vérif si user peut demander une extension
        if($emprunt->isExtension()) {
            // si extension a déjà été demandée
            $message = $translator->trans('Une extension a déjà été demandée pour ce livre ? cet emprunt ?');
            $this->addFlash('warning', );
        } elseif (!$emprunt->isEligiblePourExtension($message)) {
            // si extension n'est pas possible
            $message = $translator->trans('Extension impossible pour ce livre.');
            $this->addFlash('warning', $message);
        } else {
            // si user peut faire l'extension
            $emprunt->setExtension(true);
            $newDateFin = (clone $emprunt->getDateFin())->modify('+6 day');
            $emprunt->setDateFin($newDateFin);

            $entityManager->flush();
            $message = $translator->trans('Extension effectuee avec succès.');
            $this->addFlash('success', $message);
        }
    }

}

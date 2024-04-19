<?php

namespace App\Controller;

use App\Form\AccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(UserInterface $user): Response
    {
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user
        ]);
    }

    #[Route('/compte/modifier', name: 'app_account_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

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
}

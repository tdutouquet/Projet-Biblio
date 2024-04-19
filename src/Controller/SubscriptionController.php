<?php

namespace App\Controller;

use App\Entity\Subscription;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscriptionController extends AbstractController
{
    #[Route('/abonnement', name: 'app_subscription')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
        ]);
    }

    #[Route('/abonnement/process/{type}', name: 'app_subscription_process')]
    public function process(string $type): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        if ($type == 'monthly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            $yearlySubscription->setSubscriptionType(1);
            $yearlySubscription->setUser($user);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        if ($type == 'yearly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            $yearlySubscription->setSubscriptionType(2);
            $yearlySubscription->setUser($user);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        return $this->redirectToRoute('app_main');
    }
}

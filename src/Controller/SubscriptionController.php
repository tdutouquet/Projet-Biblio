<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class SubscriptionController extends AbstractController
{
    #[Route('/abonnement', name: 'app_subscription')]
    public function index(TranslatorInterface $translator): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $message = $translator->trans('Utilisateur non connecté');
            throw $this->createNotFoundException($message);
        }

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
        ]);
    }

    #[Route('/abonnement/process/{type}', name: 'app_subscription_process')]
    public function process(string $type, EntityManagerInterface $manager, TranslatorInterface $translator): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $message = $translator->trans('Utilisateur non connecté');
            throw $this->createNotFoundException($message);
        }

        if ($type == 'monthly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            // $yearlySubscription->setSubscriptionType(1);
            $yearlySubscription->setUser($user);
            $manager->persist($yearlySubscription);

            $message = $translator->trans('Votre abonnement a bien été mis à jour');
            $this->addFlash('success', $message);
        }

        if ($type == 'yearly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            // $yearlySubscription->setSubscriptionType(2);
            $yearlySubscription->setUser($user);
            $manager->persist($yearlySubscription);

            $message = $translator->trans('Votre abonnement a bien été mis à jour');
            $this->addFlash('success', $message);
        }

        $manager->flush();

        return $this->redirectToRoute('app_account');
    }
}

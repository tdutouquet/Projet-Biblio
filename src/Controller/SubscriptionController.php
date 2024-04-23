<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscriptionController extends AbstractController
{
    #[Route('/abonnement', name: 'app_subscription')]
    public function index(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $subs = $manager->getRepository(Subscription::class)->findBy(['user' => $user]);
        $flag = false;

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        foreach ($subs as $sub) {
            $today = new \DateTime();
            if ($today >= $sub->getStartDate() && $today <= $sub->getEndDate()) {
                $flag = true;
                break;
            }
        }

        return $this->render('subscription/index.html.twig', [
            'controller_name' => 'SubscriptionController',
            'flag' => $flag,
        ]);
    }

    #[Route('/abonnement/process/{type}', name: 'app_subscription_process')]
    public function process(string $type, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $subTypes = $manager->getRepository(SubscriptionType::class)->findAll();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        if ($type == 'monthly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            $yearlySubscription->setSubscriptionType($subTypes[0]);
            $yearlySubscription->setUser($user);
            $manager->persist($yearlySubscription);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        if ($type == 'yearly') {
            $yearlySubscription = new Subscription();
            $yearlySubscription->setEndDate(new \DateTime('+1 year'));
            $yearlySubscription->setSubscriptionType($subTypes[1]);
            $yearlySubscription->setUser($user);
            $manager->persist($yearlySubscription);

            $this->addFlash('success', 'Votre abonnement a bien été mis à jour');
        }

        $manager->flush();

        return $this->redirectToRoute('app_account');
    }
}

<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Subscription;
use App\Entity\SubscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionTypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

    #[Route('/abonnement/create-session-stripe/{type}', name: 'app_subscription_stripe')]
    public function stripe(string $type, SubscriptionTypeRepository $subTypeRepo, UserInterface $user, UrlGeneratorInterface $generator): RedirectResponse
    {
        $stripeSecretKey = 'sk_test_51P9PqKAVQGNtqCU6Kl5XUQef2605uvHe53XR1nQjdxnuwq85DxwvF98Yqr6lJwyQVNvlDAYwl0HhvEyAssnvQE3c00XWduvjaI';
        Stripe::setApiKey($stripeSecretKey);

        $order = [];
        $subTypes = $subTypeRepo->findAll();

        if ($type == 'monthly') {
            $order['name'] = 'Abonnement mensuel';
            $order['price'] = $subTypes[0]->getPrice();
        }

        if ($type == 'yearly') {
            $order['name'] = 'Abonnement annuel';
            $order['price'] = $subTypes[1]->getPrice();
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email' => $user->getEmail(),
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order['price']*100,
                    'product_data' => [
                        'name' => $order['name'],
                    ],
                ]
            ]],
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => $generator->generate('app_subscription_process', ['type' => $type], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $generator->generate('app_subscription', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url);
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

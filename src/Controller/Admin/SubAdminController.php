<?php

namespace App\Controller\Admin;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubAdminController extends AbstractController
{
    #[Route('/admin/abonnements', name: 'app_sub_admin')]
    public function index(SubscriptionRepository $subRepo): Response
    {
        $subs = $subRepo->findAll();

        return $this->render('admin/sub_admin/index.html.twig', [
            'controller_name' => 'SubAdminController',
            'subs' => $subs
        ]);
    }

    #[Route('/admin/abonnements/delete/{id}', name: 'app_sub_admin_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $sub = $entityManager->getRepository(Subscription::class)->find($id);
        $entityManager->remove($sub);
        $entityManager->flush();

        $this->addFlash('success', 'Abonnement supprimé avec succès');

        return $this->redirectToRoute('app_sub_admin');
    }
}

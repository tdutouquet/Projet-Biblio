<?php

namespace App\Controller\Admin;

use App\Entity\Salles;
use App\Form\SallesType;
use App\Repository\SallesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/salles')]
class SallesAdminController extends AbstractController
{
    #[Route('/', name: 'app_salles_admin_index', methods: ['GET'])]
    public function index(SallesRepository $sallesRepository, TranslatorInterface $translator): Response
    {
        return $this->render('admin/salles_admin/index.html.twig', [
            'salles' => $sallesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_salles_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $salle = new Salles();
        $form = $this->createForm(SallesType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salle);
            $entityManager->flush();

            return $this->redirectToRoute('app_salles_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/salles_admin/new.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salles_admin_show', methods: ['GET'])]
    public function show(Salles $salle, TranslatorInterface $translator): Response
    {
        return $this->render('admin/salles_admin/show.html.twig', [
            'salle' => $salle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salles_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salles $salle, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(SallesType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_salles_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/salles_admin/edit.html.twig', [
            'salle' => $salle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salles_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Salles $salle, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salle->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($salle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/app_salles_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}

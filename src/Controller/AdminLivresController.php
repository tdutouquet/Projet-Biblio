<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/livres')]
class AdminLivresController extends AbstractController
{
    #[Route('/', name: 'app_admin_livres_index', methods: ['GET'])]
    public function index(LivresRepository $livresRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $livres = $livresRepository->findAll();

        $pagination = $paginator->paginate(
            $livres,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin_livres/index.html.twig', [
            'livres' => $livres,
            'pagination' => $pagination
        ]);
    }

    #[Route('/new', name: 'app_admin_livres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livres();
        $form = $this->createForm(LivresType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_livres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_livres/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livres_show', methods: ['GET'])]
    public function show(Livres $livre): Response
    {
        return $this->render('admin_livres/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_livres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livres $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivresType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_livres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_livres/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livres_delete', methods: ['POST'])]
    public function delete(Request $request, Livres $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_livres_index', [], Response::HTTP_SEE_OTHER);
    }
}

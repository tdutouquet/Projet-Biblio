<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentAdminController extends AbstractController
{
    #[Route('/admin/comment', name: 'app_comment_admin')]
    public function index(CommentRepository $commRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $comments = $commRepo->findAll();
        
        $pagination = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            7
        );

        return $this->render('admin/comment_admin/index.html.twig', [
            'controller_name' => 'CommentAdminController',
            'comments' => $comments,
            'pagination' => $pagination
        ]);
    }

    #[Route('/admin/comment/delete/{id}', name: 'app_comment_admin_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Commentaire supprimé avec succès');

        return $this->redirectToRoute('app_comment_admin');
    }
}

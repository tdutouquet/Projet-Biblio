<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentAdminController extends AbstractController
{
    #[Route('/admin/comment', name: 'app_comment_admin')]
    public function index(CommentRepository $commRepo): Response
    {
        $comments = $commRepo->findAll();

        return $this->render('admin/comment_admin/index.html.twig', [
            'controller_name' => 'CommentAdminController',
            'comments' => $comments
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

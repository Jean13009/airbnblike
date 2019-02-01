<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * Modifier un commentaire en admin
     * 
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     */

    public function edit(Comment $comment, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire numéro {$comment->getId()} a bien été modifié"
            );
        }

        return $this->render('admin/comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

            /**
            * Supprimer un commentaire
            * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
            * 
            */
            
            public function delete(Comment $comment, ObjectManager $manager) {

                    $manager->remove($comment);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        "Le commentaire <strong>{$comment->getAuthor()->getFullname()}</strong> a bien été supprimée"
                    );
                
                return $this->redirectToRoute('admin_comments');
                
            }
}

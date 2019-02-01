<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
    * @Route("/admin/annonces", name="admin_ans_index")
    */
    public function index(AdRepository $repo)
    {
        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $repo->findAll()
            ]);
        }
        
        /**
        * Edition d'une annonce
        *
        * @Route("/admin/annonces/{id}/edit", name="admin_annonces_edit")
        * @param Ad $ad
        * @return void
        */
        public function edit(Ad $ad, Request $request, ObjectManager $manager)
        {
            $form = $this->createForm(AnnonceType::class, $ad);
            
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()) {
                $manager->persist($ad);
                $manager->flush();
                
                $this->addFlash(
                    'success',
                    "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée"
                );
            }
            return $this->render('admin/annonces/edit.html.twig', [
                'ad' => $ad,
                'form' => $form->createView()
                ]);
            }
            
            /**
            * Supprimer une annonce
            * @Route("/admin/annonces/{id}/delete", name="admin_ad_delete")
            * 
            */
            
            public function delete(Ad $ad, ObjectManager $manager) {
                if(count($ad->getBookings()) > 0) {
                    $this->addFlash(
                        'warning',
                        "Vous ne pouvez pas supprimer l'annonce <strong>{$ad->getTitle()}</strong> car elle possède déjà des réservations"
                    );
                } else {
                    $manager->remove($ad);
                    $manager->flush();
                    $this->addFlash(
                        'success',
                        "L'annonce <strong>{$ad->getTitle()}</strong> a bien été supprimée"
                    );
                }
                return $this->redirectToRoute('admin_ans_index');
                
            }
            
            /**
            * 
            * Gérer les commentaires
            * 
            * @Route("/admin/comments/", name="admin_comments")
            * 
            */
            public function comments(CommentRepository $comment) {
                return $this->render('admin/comments/comments.html.twig', [
                    'comments' => $comment->findBy([], ['id' => 'DESC'])
                    ]);
                }
                
            }
            
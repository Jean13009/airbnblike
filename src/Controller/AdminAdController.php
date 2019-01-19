<?php

namespace App\Controller;

use App\Repository\AdRepository;
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
    }
    
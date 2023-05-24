<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//on definit un parametre de route : 
#[Route(path: '/app', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[
        Route('/admin', name: 'admin'),
        IsGranted('ROLE_ADMIN')
    ]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

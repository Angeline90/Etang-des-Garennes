<?php

namespace App\Controller;

use App\Repository\CottageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//on definit un parametre de route : 
#[Route(path: '/app', name: 'app_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CottageRepository $cottageRepository): Response
    {
        $cottages = $cottageRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'cottages' => $cottages,
        ]);
    }
}

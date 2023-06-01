<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[
    Route('/app/booking', name: 'app_booking_')
    ]
class BookingController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('booking/_index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
}

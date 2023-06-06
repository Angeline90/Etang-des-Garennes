<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[
        Route('/my', name: 'my_booking'),
        IsGranted('ROLE_USER')
    ]
    public function myBooking(BookingRepository $bookingRepository): Response
    {
        $bookings = $this->isGranted('ROLE_ADMIN') ? $bookingRepository->findAll() : $this->getUser()->getBookings();
        return $this->render('booking/my_booking.html.twig', [
            'bookings' => $bookings,
        ]);
    }

}

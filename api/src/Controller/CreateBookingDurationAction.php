<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
final class CreateBookingDurationAction extends AbstractController
{
    /** @param Booking $data */
    public function __invoke($data, BookingService $bookingService): Booking
    {
        return $bookingService->create($data);

        //dd($data, $interval->days);
    }
}

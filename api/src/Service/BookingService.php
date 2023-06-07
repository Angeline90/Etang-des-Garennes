<?php

namespace App\Service;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookingService
{
    public function __construct(private BookingRepository $bookingRepository)
    {
    }

    function create(Booking $booking): Booking
    {
        $interval = $booking->getArrivalDate()->diff($booking->getDepartureDate());
        $booking->setDuration($interval);
        $arrivalTime = $booking->getCottage()->getArrivalTime();
        $departureTime = $booking->getCottage()->getDepartureTime();

        $arrivalTime = date_time_set(
            $booking->getArrivalDate(),
            +$arrivalTime->format('H'),
            +$arrivalTime->format('i'),

        );

        $departureTime = date_time_set(
            $booking->getDepartureDate(),
            +$departureTime->format('H'),
            +$departureTime->format('i'),

        );

        if ($arrivalTime >= $departureTime) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Les dates ne sont pas correctes.');
        }

        $bookings = $this->bookingRepository->getListForGivenPeriod($arrivalTime, $departureTime, $booking->getCottage());

        if (count($bookings)) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Ce créneau n\'est plus disponible.');
        }

        return $booking;
    }
}

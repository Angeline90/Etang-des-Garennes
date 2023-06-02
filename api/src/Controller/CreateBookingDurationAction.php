<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class CreateBookingDurationAction extends AbstractController
{
    /** @param Booking $data */
    public function __invoke($data) : Booking
    {
        $interval = $data->getArrivalDate()->diff($data->getDepartureDate());
        $data->setDuration($interval);
        return $data;
        //dd($data, $interval->days);
    }
}
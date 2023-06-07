<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingState;
use App\Entity\Cottage;
use App\Repository\BookingRepository;
use App\Repository\BookingStateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsController]
final class ChargePaymentForBookingAction extends AbstractController
{

    public function __construct(private string $stripeSecretKey) 
    {
        
    }
    
    /** @param Booking $data */
    public function __invoke($data, Request $request, BookingStateRepository $bookingStateRepository, BookingRepository $bookingRepository): Booking
    {
        if ($data->getBookingState()->getState() !== BookingState::WAITING_FOR_PAYMENT )
        {
            throw new HttpException(Response::HTTP_FORBIDDEN ,'Aucun paiement en attente');
        }

        $bookings = $bookingRepository->getListForGivenPeriod($data->getArrivalDate(), $data->getDepartureDate(), $data->getCottage());

        if (count($bookings)) {
            throw new HttpException(418, "Trop tard, va prendre une tasse de thé !");
        }

        $body = json_decode($request->getContent());

        if (empty($body->token)) 
        {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY ,'Token de paiement invalide');
        }

        Stripe::setApiKey($this->stripeSecretKey);
        // Token is created using Stripe Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $charge = Charge::create([
            'amount' => $data->getFormattedDuration() * $data->getCottage()->getPrice() * 100,
            'currency' => 'eur',
            'description' => 'Réservation ' . $data->getId(),
            'source' => $body->token,
        ]);

        if ($charge->status === 'succeeded') {
            $data->setStripePayment($charge->id);
            $state = $bookingStateRepository->findOneBy(['state' => BookingState::VALIDATE ]);
            $data->setBookingState($state);

            $bookingRepository->save($data);

        }

        return $data;
    }
}

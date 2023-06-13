<?php

namespace App\DataFixtures;

use App\Entity\BookingState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookingStateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bookingStateValidate = new BookingState();
        $bookingStateValidate->setState(BookingState::VALIDATE);
        $bookingStateWFP = new BookingState();
        $bookingStateWFP->setState(BookingState::WAITING_FOR_PAYMENT);
        // $product = new Product();
        $manager->persist($bookingStateValidate);
        $manager->persist($bookingStateWFP);

        $manager->flush();
    }
}

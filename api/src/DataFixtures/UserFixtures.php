<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('userTest@test.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('abcdef');
        $manager->persist($user);

        $manager->flush();
    }
}

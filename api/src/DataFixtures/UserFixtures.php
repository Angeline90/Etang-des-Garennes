<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Session\SymfonyRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = self::REFERENCE.'admin';
    public const MAIL_HOST = '@garenne.fr';
    public const REFERENCE = 'user_';
    public const SUPER_ADMIN_USER_REFERENCE = self::REFERENCE.'super_admin';
    public const TOTAL_FIXTURES = 5;
    public const USER_PASSWORD = '1user_Password';

    public const FIXTURES = [
        [
            'reference' => self::ADMIN_USER_REFERENCE,
            'role' => 'ROLE_ADMIN',
        ],
        [
            'reference' => self::SUPER_ADMIN_USER_REFERENCE,
            'role' => 'ROLE_SUPER_ADMIN',
        ],
    ];

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::TOTAL_FIXTURES; ++$i) {
            $reference = self::REFERENCE.$i;
            $user = new User();

            $user->setEmail($reference.static::MAIL_HOST)
                ->setPassword($this->passwordEncoder->hashPassword($user, self::USER_PASSWORD))
                ->setFirstname($reference)
                ->setName($reference)
            ;

            $manager->persist($user);
            $this->addReference($reference, $user);
        }

        foreach (self::FIXTURES as $fixture) {
            $user = new User();

            $user->setEmail($fixture['reference'].self::MAIL_HOST)
                ->setPassword($this->passwordEncoder->hashPassword($user, self::USER_PASSWORD))
                ->setFirstname($reference)
                ->setName($reference)
                ->addRole($fixture['role']);

            $manager->persist($user);
            $this->addReference($fixture['reference'], $user);
        }

        $manager->flush();
    }
}

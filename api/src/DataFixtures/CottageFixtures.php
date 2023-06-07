<?php

namespace App\DataFixtures;

use App\Entity\Cottage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CottageFixtures extends Fixture
{
    public const COTTAGES = [

        [
            'owners' => '17',
            'name' => 'Chambre bleue',
            'description' => 'Chambre pouvant accueillir 4 personnes, sur le thème relaxant de la mer',
            'price' => '150 ',
            'capacity' => '4',
        ],

        [
            'owners' => '17',
            'name' => 'Chambre rouge',
            'description' => 'Chambre à la décoration revitallisante , idéale pour 2 personnes',
            'price' => '120 ',
            'capacity' => '2',
        ],
        [
            'owners' => '17',
            'name' => 'Chambre jaune ',
            'description' => 'Idéale pour une famille de 4 personnes ',
            'price' => '150 ',
            'capacity' => '4',
        ],
        [
            'owners' => '17',
            'name' => 'Chambre violette',
            'description' => 'dépaysement garanti pour un week-end en amoureux, cette chambre vous transportera dans le Sud Est , lavande et cigales , avec un spa privé',
            'price' => '150 ',
            'capacity' => '2',
        ],
        [
            'owners' => '17',
            'name' => 'Appart',
            'description' => 'un appart New Yorkais , jusqu\'à 6 personnes ',
            'price' => '200',
            'capacity' => '6',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::COTTAGES as $key => $currentCottage) {
            $cottage = new Cottage();
            $cottage->getOwners();
            $cottage->setName($currentCottage['name']);
            $cottage->setDescription($currentCottage['description']);
            $cottage->setPrice($currentCottage['price']);
            $cottage->setCapacity($currentCottage['capacity']);
            $manager->persist($cottage);


            $manager->flush();
        }
    }
}

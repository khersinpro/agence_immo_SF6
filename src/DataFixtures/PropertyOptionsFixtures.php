<?php

namespace App\DataFixtures;

use App\Entity\PropertyOptions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyOptionsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $allOptionsChoices = ['Balcon', 'Adapté PMR', 'Ascenseur', 'Basse consomation'];

        // foreach ($allOptionsChoices as $choice) {
        //     $option = new PropertyOptions();
        //     $option->setName($choice);
        //     $manager->persist($option);
        // }

        // $manager->flush();
    }
}

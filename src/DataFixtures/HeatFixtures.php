<?php

namespace App\DataFixtures;

use App\Entity\PropertyHeat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $heatList = ['Gaz', 'Electrique', 'Fioul', 'Bois'];

        // foreach ($heatList as $category) {
        //     $heat = new PropertyHeat();
        //     $heat->setName($category);
        //     $manager->persist($heat);
        // }

        // $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Repository\PropertyHeatRepository;
use App\Repository\PropertyOptionsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    private $optionsRepo;
    private $heatRepo;

    public function __construct(PropertyOptionsRepository $optionsRepo, PropertyHeatRepository $heatRepo)
    {
        $this->optionsRepo =$optionsRepo;
        $this->heatRepo =$heatRepo;
    }

    public function load(ObjectManager $manager): void
    {
        $allHeatsType = $this->heatRepo->findAll();
        $allAllowedOptions = $this->optionsRepo->findAll();

        $faker = Factory::create('fr_FR');
        for ($i= 0; $i < 100; $i++) {
            $property = new Property();
            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(20, 350))
                ->setRooms($faker->numberBetween(2, 10))
                ->setBedrooms($faker->numberBetween(1, 9))
                ->setFloor($faker->numberBetween(0, 15))
                ->setPrice($faker->numberBetween(30000, 850000))
                ->setHeat($allHeatsType[ $faker->numberBetween(0, count($allHeatsType) - 1) ])
                ->addOption($allAllowedOptions[ $faker->numberBetween(0, count($allAllowedOptions) - 1) ])
                ->setCity($faker->city())
                ->setAddress($faker->address())
                ->setPostalCode($faker->numberBetween(1000, 9999))
                ->setSold(false);
                $manager->persist($property);
        }
        $manager->flush();

        $manager->flush();
    }
}

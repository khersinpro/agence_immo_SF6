<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager)
    {
        // $admin = new User();
        // $admin->setEmail('admin@admin.fr')
        //     ->setPassword($this->hasher->hashPassword($admin, 'test'))
        //     ->setRoles(['ROLE_ADMIN']);
        // $manager->persist($admin);test
        // $manager->flush();
    }
}

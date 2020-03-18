<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        for($i=0;$i<20;$i++){
            $user = new User();
            $user->setUsername("User".$i)
            ->setPassword("Abc".$i*838)
            ->setMail("User".$i."@fixtures.com")
            ->setGender(random_int(1,2));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

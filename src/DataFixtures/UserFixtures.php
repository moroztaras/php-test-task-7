<?php

namespace App\DataFixtures;

use App\Entity\MobileNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Fixtures for one user
        $user = new User();
        $user
            ->setFirstName('Taras')
            ->setLastName('Moroz')
            ->setBirthday(new \DateTime())
        ;
        $manager->persist($user);

        //Fixtures for mobile number
        $balance = rand(-150.0,150.0);

        $mobileNumberOne = new MobileNumber();
        $mobileNumberOne
            ->setNameOperator('KyivStar')
            ->setCodeCountry('380')
            ->setCodeOperator('68')
            ->setNumber('1234567')
            ->setBalance((float) $balance)
            ->setUser($user)
        ;

        $manager->persist($mobileNumberOne);

        //Fixtures for mobile number
        $balance = rand(-150.0,150.0);

        $mobileNumberTwo = new MobileNumber();
        $mobileNumberTwo
            ->setNameOperator('Vodofone')
            ->setCodeCountry('380')
            ->setCodeOperator('50')
            ->setNumber('7654321')
            ->setBalance((float) $balance)
            ->setUser($user)
        ;

        $manager->persist($mobileNumberTwo);

        //Fixtures for mobile number
        $balance = rand(-150.0,150.0);

        $mobileNumberThree = new MobileNumber();
        $mobileNumberThree
            ->setNameOperator('Life')
            ->setCodeCountry('380')
            ->setCodeOperator('63')
            ->setNumber('1029384')
            ->setBalance((float) $balance)
            ->setUser($user)
        ;

        $manager->persist($mobileNumberThree);

        $manager->flush();
    }
}
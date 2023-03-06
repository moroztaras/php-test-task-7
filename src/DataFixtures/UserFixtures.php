<?php

namespace App\DataFixtures;

use App\Entity\MobilePhone;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setFirstName('Taras')
            ->setLastName('Moroz')
            ->setBirthday(new \DateTime())
        ;
        $manager->persist($user);

        $countMobilePhone = rand(1,3);
        for($i=1; $i<=$countMobilePhone; $i++) {
            $mobilePhone = new MobilePhone();
            $mobilePhone
                ->setNameOperator('KyivStar')
                ->setCodeCountry('380')
                ->setCodeOperator('68')
                ->setNumber('1234567')
                ->setBalance(50.0)
                ->setUser($user)
            ;

            $manager->persist($mobilePhone);
        }

        $manager->flush();
    }
}
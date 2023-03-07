<?php

namespace App\DataFixtures;

use App\Entity\MobileNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Use faker
        $faker = Factory::create('EN_en');

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
            ->setNameOperator('Vodafone')
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

        //Fixtures for lot users and mobile numbers
        for ($i=1; $i<=4; $i++)
        {
            $user = new User();
            $user
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setBirthday($faker->dateTimeThisYear)
            ;
            $manager->persist($user);

            $countMobileNumbers = rand(1,3);

            for ($j=1; $j<=$countMobileNumbers; $j++)
            {
                $randNumber = rand(0,3);
                $operators = ['Vodafone','KyivStar','Life','KyivStar'];
                $codeOperators = [50, 67, 63, 68];
                $number = rand(1000000,9999999);
                $balance = rand(-150.0,150.0);

                $mobileNumber = new MobileNumber();
                $mobileNumber
                    ->setNameOperator($operators[$randNumber])
                    ->setCodeCountry('380')
                    ->setCodeOperator($codeOperators[$randNumber])
                    ->setNumber($number)
                    ->setBalance((float) $balance)
                    ->setUser($user)
                ;

                $manager->persist($mobileNumber);
            }
        }

        $manager->flush();
    }
}
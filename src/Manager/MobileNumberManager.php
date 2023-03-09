<?php

namespace App\Manager;

use App\Entity\MobileNumber;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class MobileNumberManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    //Add new mobile number to user
    public function add(User $user, $data): MobileNumber
    {
        $mobileNumber = new MobileNumber();
        $mobileNumber
            ->setNameOperator($data['name_operator'])
            ->setCodeCountry($data['code_country'])
            ->setCodeOperator($data['code_operator'])
            ->setNumber($data['code_operator'])
            ->setUser($user)
        ;

        return $this->save($mobileNumber,$user);
    }

    //Save MobileNumber in DB
    private function save(MobileNumber $mobileNumber, User $user):MobileNumber
    {
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->persist($mobileNumber);
        $this->doctrine->getManager()->flush();

        return $mobileNumber;
    }
}
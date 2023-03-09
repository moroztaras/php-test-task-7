<?php

namespace App\Manager;

use App\Entity\MobileNumber;
use App\Entity\User;
use App\Exception\Helper\BadRequestJsonHttpException;
use App\Exception\JsonHttpException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Response;

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

    //Top up balance mobile number
    public function topUpBalance(MobileNumber $mobileNumber, $data): MobileNumber
    {
        $topUpAmount = $data['top_up_amount'];

        if($topUpAmount > 100.0)
        {
            throw new JsonException('The top-up amount is more than UAH 100.',Response::HTTP_BAD_REQUEST, );
        }

        $mobileNumber->setBalance($mobileNumber->getBalance()+$topUpAmount);

        return $this->save($mobileNumber,$mobileNumber->getUser());
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
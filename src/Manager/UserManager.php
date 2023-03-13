<?php

namespace App\Manager;

use App\Entity\MobileNumber;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class UserManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
    ) {
    }

    //create new user
    public function create($data): User
    {
        $user = new User();
        $user
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setBirthday(new \DateTime($data['birthday']))
        ;

        return $this->save($user);
    }

    public function remove(User $user): bool
    {
        //Remove all mobile numbers of user
        foreach ($user->getMobileNumbers() as $mobileNumber)
        {
            $this->doctrine->getManager()->remove($mobileNumber);
        }

        //Remove user
        $this->removeUser($user);

        return true;
    }

    //Balance by every user and operator
    public function sumaBalancesByEveryUserAndOperator():array
    {
        return $this->doctrine->getRepository(MobileNumber::class)->sumaBalances();
    }

    //Count numbers by every code operator
    public function countNumbersByCodeOperator():array
    {
        return $this->doctrine->getRepository(MobileNumber::class)->countNumbers();
    }

    //Count numbers by every user
    public function numbersEveryUser():array
    {
        return $this->doctrine->getRepository(MobileNumber::class)->countNumbersEveryUser();
    }

    //Users with max balance
    public function usersWithBalance():array
    {
        return $this->doctrine->getRepository(MobileNumber::class)->getUsersWithBalance();
    }

    //Save user in DB
    private function save(User $user):User
    {
       $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

        return $user;
    }

    //Remove user in DB
    private function removeUser(User $user):User
    {
        $this->doctrine->getManager()->remove($user);
        $this->doctrine->getManager()->flush();

        return $user;
    }
}
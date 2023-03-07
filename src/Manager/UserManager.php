<?php

namespace App\Manager;

use App\Entity\MobileNumber;
use App\Entity\User;
use App\Exception\JsonHttpException;
use App\Validator\Helper\ApiObjectValidator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private ValidatorInterface $validator,
        private ApiObjectValidator $apiObjectValidator,
    ) {
    }

    public function create ($content): User
    {
        /* @var User $user */
        $user = $this->apiObjectValidator->deserializeAndValidate($content, User::class, [UnwrappingDenormalizer::UNWRAP_PATH => '[user]']);

        $errors = $this->validator->validate($user);
        if (count($errors)) {
            throw new JsonHttpException(400, (string) $errors->get(0)->getPropertyPath().': '.(string) $errors->get(0)->getMessage());
        }
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

        return $user;
    }

    public function remove(User $user): bool
    {
        //Remove all mobile numbers of user
        foreach ($user->getMobileNumbers() as $mobileNumber)
        {
            $this->doctrine->getManager()->remove($mobileNumber);
        }

        //Remove user
        $this->doctrine->getManager()->remove($user);
        $this->doctrine->getManager()->flush();

        return true;
    }

    //Balance by every user and operator
    public function sumaBalancesByEveryUserAndOperator():array
    {
        return $this->doctrine->getRepository(MobileNumber::class)->sumaBalances();
    }
}
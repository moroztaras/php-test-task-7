<?php

namespace App\Manager;

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

}
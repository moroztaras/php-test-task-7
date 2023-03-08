<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\JsonHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class UserController.
 */
#[Route('api/user')]
class UserController extends AbstractController
{
    public function __construct(
        private UserManager $userManager,
    ){
    }

    #[Route('/{id}', name: 'api_user_show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
        if (!$user) {
            throw new JsonException('User Not Found',404);
        }
        return $this->json(['user' => $user]);
    }


    #[Route('/registration', name: 'api_user_registration', methods: ['GET', 'POST'])]
    public function registration(Request $request): JsonResponse
    {
        if (!$content = $request->getContent()) {
            throw new JsonHttpException(400, 'Bad Request');
        }
        $user = $this->userManager->create($content);

        return $this->json($user);
    }

    #[Route('/{id}/edit', name: 'api_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {

    }

    #[Route('/{id}/remove', name: 'api_user_delete', methods: ['DELETE'])]
    public function delete(User $user): Response
    {
        if (!$user) {
            throw new JsonException('User Not Found',404);
        }
        $this->userManager->remove($user);

        return $this->json('User removed successfully.');
    }


    //Get balance every user and operators (1)
    #[Route('/{id}/suma-balances', name: 'api_suma_balances', methods: ['GET'])]
    public function balance(User $user): JsonResponse
    {
        return $this->json(['balances' => $this->userManager->sumaBalancesByEveryUserAndOperator()]);
    }

    //Get count mobile numbers by code operator (2)
    #[Route('/{id}/numbers', name: 'api_numbers', methods: ['GET'])]
    public function countNumbers (User $user): JsonResponse
    {
        return $this->json(['numbers' => $this->userManager->countNumbersByCodeOperator()]);
    }

    //Get count of phone numbers every user. (3)
    #[Route('/{id}/count-numbers-every-user', name: 'api_count_numbers_every_user', methods: ['GET'])]
    public function countNumbersUser (User $user): JsonResponse
    {
        return $this->json($this->userManager->numbersEveryUser());
    }

    //Get ten users with max balance. (4)
    #[Route('/{id}/user-max-balance', name: 'api_user_max_balance', methods: ['GET'])]
    public function usersWithMaxBalance (User $user): JsonResponse
    {
        return $this->json($this->userManager->usersWithBalance());
    }
}

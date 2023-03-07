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
    public function registration(Request $request, UserRepository $userRepository): JsonResponse
    {
        if (!$content = $request->getContent()) {
            throw new JsonHttpException(400, 'Bad Request');
        }
        $user = $this->userManager->create($content);

        return $this->json($user);
    }

    #[Route('/{id}/edit', name: 'api_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {

    }

    #[Route('/{id}', name: 'api_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {

    }
}

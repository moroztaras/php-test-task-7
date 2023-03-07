<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 */
#[Route('api/user')]
class UserController extends AbstractController
{
    #[Route('/{id}', name: 'api_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if (!$user) {
            throw new JsonException('User Not Found',404);
        }
        foreach ($user->getMobileNumbers() as $mobileNumber)
        {
            var_dump($mobileNumber->getNameOperator());
        }
        return $this->json([
            'user' => $user,
//            'mobile_numbers' => $user->getMobileNumbers()
        ]);
    }

    #[Route('/', name: 'api_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
//        return $this->render('user/index.html.twig', [
//            'users' => $userRepository->findAll(),
//        ]);
    }

    #[Route('/new', name: 'api_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $userRepository->save($user, true);
//
//            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('user/new.html.twig', [
//            'user' => $user,
//            'form' => $form,
//        ]);
    }



    #[Route('/{id}/edit', name: 'api_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $userRepository->save($user, true);
//
//            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('user/edit.html.twig', [
//            'user' => $user,
//            'form' => $form,
//        ]);
    }

    #[Route('/{id}', name: 'api_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
//        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//            $userRepository->remove($user, true);
//        }
//
//        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}

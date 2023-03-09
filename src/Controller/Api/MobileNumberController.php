<?php

namespace App\Controller\Api;

use App\Entity\MobileNumber;
use App\Entity\User;
use App\Manager\MobileNumberManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\JsonHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class MobilePhoneNumberController.
 */
#[Route('api/mobile-number')]
class MobileNumberController extends AbstractController
{
    public function __construct(
        private MobileNumberManager $mobileNumberManager,
    ){
    }

    //Add new mobile number to user (4)
    #[Route('/{id}/add', name: 'api_mobile_number_add', methods: ['GET', 'POST'])]
    public function add (Request $request, User $user): JsonResponse
    {
        if (!$content = $request->getContent()) {
            throw new JsonHttpException(Response::HTTP_BAD_REQUEST, 'Bad Request');
        }

        if (!$user) {
            throw new JsonException('User Not Found',Response::HTTP_NOT_FOUND);
        }

        $mobileNumber = $this->mobileNumberManager->add($user, json_decode($content, true));

        return $this->json(['mobileNumber' => $mobileNumber]);
    }

    //Topping up the balance of a mobile number
    #[Route('/{id}/top-up-balance', name: 'api_mobile_number_top_up_balance', methods: ['GET', 'POST'])]
    public function topUpBalance (Request $request, MobileNumber $mobileNumber): JsonResponse
    {
        if (!$content = $request->getContent()) {
            throw new JsonHttpException(Response::HTTP_BAD_REQUEST, 'Bad Request');
        }

        if (!$mobileNumber) {
            throw new JsonException('Mobile Number Not Found',Response::HTTP_NOT_FOUND);
        }

        $mobileNumber = $this->mobileNumberManager->topUpBalance($mobileNumber, json_decode($content, true));

        return $this->json(['mobileNumber' => $mobileNumber]);
    }
}

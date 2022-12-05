<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Repository\MeetingRepository;
use App\Repository\RateRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController
{
    private MeetingRepository $meetingRepository;
    private UserRepository $userRepository;
    private RateRepository $rateRepository;

    public function __construct(MeetingRepository $meetingRepository, UserRepository $userRepository, RateRepository $rateRepository)
    {
        $this->meetingRepository = $meetingRepository;
        $this->userRepository = $userRepository;
        $this->rateRepository = $rateRepository;
    }

    #[Route('/meetings/{id}', name: 'meeting')]
    public function meeting(string $meetingId): Response
    {
        $meeting = $this->meetingRepository->get($meetingId);
        return new JsonResponse($meeting);
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return new Response('<h1>Hello</h1>');
    }

    #[Route('/meetings/{id}/rate', name: 'rate',methods: ["POST"])]
    public function addRate(string $id,Request $request):JsonResponse
    {
        $rateValue = $request->get('value');
        $userId = $request->get('userId');


        $meeting = $this->meetingRepository->get($id);
        $user = $this->userRepository->get($userId);

        $response = 'done';

        try {
            $rate = new Rate($rateValue, $user, $meeting);
            $this->rateRepository->add($rate);
        }
        catch (\Exception $exception)
        {
            $response = $exception->getMessage();
        }


        return new JsonResponse($response);
    }
}

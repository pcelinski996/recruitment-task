<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Repository\MeetingRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController
{
    private MeetingRepository $meetingRepository;

    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
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
        $meeting = $this->meetingRepository->get($id);
        $rateValue = $request->get('value');

        $meeting->

        return new JsonResponse();
    }
}

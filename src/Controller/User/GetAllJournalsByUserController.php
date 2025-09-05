<?php

namespace App\Controller\User;


use App\MiMascota\Journals\Application\JournalGetAllData;
use App\MiMascota\Journals\Application\Query\GetAllJournalsByUserIdQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Shared\SerializerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetAllJournalsByUserController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait, SerializerTrait;
    #[Route('/journals', name: 'user_journals', methods: ['GET'])]
    public function __invoke(Request $request, JournalGetAllData $getData): JsonResponse
    {
        try {
            $user = $this->checkAuthorization($request);
            $journals = $getData->__invoke(new GetAllJournalsByUserIdQuery($user->getId()));
            return $this->successResponse(  $journals, 'Journals retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetAllJournalsByUserController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/user/journals', name: 'user_journals', methods: ['GET'])]
    public function __invoke(Request $request, UserRepository $repository): JsonResponse
    {
        $user = $this->checkAuthorization($request);
        $journals = $repository->getJournals($user->getId());
        $journals = $journals->toArray();
        return $this->successResponse($journals, 'Journals retrieved successfully');
    }
}

<?php

namespace App\Controller\Journal;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Domain\UserRepository;
use App\MiMascota\Users\Infrastructure\UserLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JournalGetAllController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal', name: 'journal_get', methods: ['GET'])]
    public function __invoke(Request $request,UserLogin $login,UserRepository $repository): JsonResponse
    {
        $user = $this->checkAuthorization($request, $login);
        $journals = $repository->getJournals($user->getId());
        $journals = $journals->toArray();
        return $this->successResponse($journals, 'Journals retrieved successfully');
    }
}

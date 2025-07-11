<?php

namespace App\Controller\Journal;

use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\UserLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JournalGetAllEntriesController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal/entries/{journal_id}/{page}', name: 'journal_get_entries', methods: ['GET'])]
    public function __invoke(Request $request,UserLogin $login,JournalRepository $repository): JsonResponse
    {
        $this->checkAuthorization($request, $login);
        $journalId = $request->get('journal_id');
        $page = $request->get('page');
        $entries = $repository->getEntries($journalId, $page);
        $entries = $entries->toArray();
        return $this->successResponse($entries, 'Entries retrieved successfully');


    }
}

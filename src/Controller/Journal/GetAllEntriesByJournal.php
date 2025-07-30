<?php

namespace App\Controller\Journal;

use App\MiMascota\Entries\Application\EntryGetMany;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllEntriesByJournal extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal/entries/{journal_id}/{page}', name: 'journal_get_entries', methods: ['GET'])]
    public function __invoke(
        Request $request,
        string $journal_id,
        string $page,

        EntryGetMany $entryGetMany
    ): Response
    {
        $this->checkAuthorization($request);
        $entries = $entryGetMany->__invoke($journal_id, $page);
        return $this->successResponse($entries, 'Entries retrieved successfully');
    }
}

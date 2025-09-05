<?php

namespace App\Controller\Journal;

use App\MiMascota\Entries\Application\DTO\EntryResponseCollection;
use App\MiMascota\Entries\Application\EntryGetManyPagination;
use App\MiMascota\Entries\Application\Query\EntryGetByJournalSlugPaginationQuery;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

class GetAllEntriesByJournalController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal/entries/{journal_slug}/{page}', name: 'journal_get_entries', methods: ['GET'])]
    public function __invoke(
        Request                $request,
        string                 $journal_slug,
        string                 $page,

        EntryGetManyPagination $entryGetMany
    ): Response
    {
        try {
            $this->checkAuthorization($request);
            $entries = $entryGetMany->__invoke(new EntryGetByJournalSlugPaginationQuery($journal_slug, $page));

            return $this->successResponse(EntryResponseCollection::generate($entries[0]), 'Entries retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), $exception->getCode(), Response::HTTP_OK);
        }
    }
}

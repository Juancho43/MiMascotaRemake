<?php

namespace App\Controller\Journal;

use App\MiMascota\Journals\Application\JournalSoftDelete;
use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JournalDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal/delete/{id}', name: 'journal_delete', methods: ['DELETE'])]
    public function __invoke(Request $request, string $id, JournalSoftDelete $journalSoftDelete) : Response
    {
        try{
            $user = $this->checkAuthorization($request);
            $command = new GetJournalByIdQuery($id);
            $journalSoftDelete->__invoke($command);
            return $this->successResponse(message: 'Journal deleted successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

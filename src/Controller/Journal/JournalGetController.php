<?php

namespace App\Controller\Journal;

use App\MiMascota\Journals\Application\DTO\JournalResponse;
use App\MiMascota\Journals\Application\JournalGetById;
use App\MiMascota\Journals\Application\JournalGetData;
use App\MiMascota\Journals\Application\Query\GetJournalByIdQuery;
use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JournalGetController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;

    #[Route('/journal/{slug}', name: 'journal_get', methods: ['GET'])]
    public function __invoke(
        Request             $request,
        CheckToken          $login,
        string              $slug,
        JournalGetData      $journalGetData,
        JournalGetById $journalGetById,
    ): JsonResponse
    {
        try{
            $this->checkAuthorization($request);
            return $this->successResponse(
                JournalResponse::generate($journalGetData->__invoke(new GetJournalByIdQuery($slug))),
                'Journal retrieved successfully'
            );
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

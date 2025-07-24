<?php

namespace App\Controller\Entries;

use App\MiMascota\Entries\Application\EntryCreator;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryNewController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/entry', name: 'entry_create', methods: ['POST'])]
    public function create(Request $request, EntryCreator $creator) : Response
    {
        $this->checkAuthorization($request);

        $data = $request->toArray();
        $entry = $creator->__invoke(
            $data['journal_id'],
            $data['title'],
            $data['content'],
            $data['date']
        );

        return $this->successResponse(EntryResponse::generate($entry), 'Entry created successfully', Response::HTTP_CREATED);

    }
}

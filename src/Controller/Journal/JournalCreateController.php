<?php

namespace App\Controller\Journal;


use App\MiMascota\Journals\Application\DTO\JournalCreatedResponse;
use App\MiMascota\Journals\Application\JournalCreator;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Shared\SerializerTrait;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JournalCreateController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait, SerializerTrait;
    #[Route('/journal/create', name: 'journal_create', methods: ['POST'])]
    public function create(Request $request, JournalCreator $creator) : Response
    {

        $user =$this->checkAuthorization($request);

        $data = $request->toArray();
        $journal = $creator->__invoke(
            $user,
            $data['name'],
            $data['breed'],
            new DateTime($data['birthdate']),
            $data['gender'],
            $data['weight'],
            $data['size'],
            $data['color'],
            $data['description'],
        );

       return $this->successResponse(JournalCreatedResponse::fromJournal($journal),'Journal created successfully', Response::HTTP_CREATED);
    }

}

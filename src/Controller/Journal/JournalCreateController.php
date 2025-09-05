<?php

namespace App\Controller\Journal;


use App\MiMascota\Journals\Application\Command\CreateJournalCommand;
use App\MiMascota\Journals\Application\DTO\JournalResponse;
use App\MiMascota\Journals\Application\JournalCreator;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class JournalCreateController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/journal/create', name: 'journal_create', methods: ['POST'])]
    public function create(Request $request, JournalCreator $creator) : Response
    {
        try{
            $user = $this->checkAuthorization($request);

            $data = $request->toArray();
            $command = new CreateJournalCommand(
                $user->getId(),
                $data['name'],
                $data['breed'],
                $data['birthdate'],
                $data['gender'],
                $data['weight'],
                $data['size'],
                $data['color'],
                $data['description'],
            );
            $journal = $creator->__invoke($command);
            return $this->successResponse(JournalResponse::generate($journal),'Journal created successfully', Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }

}

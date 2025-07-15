<?php

namespace App\Controller\Journal;


use App\MiMascota\Journals\Application\JournalCreator;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JournalCreateController extends AbstractController
{
    #[Route('/journal', name: 'journal_create', methods: ['POST'])]
    public function create(Request $request, CheckToken $login, JournalCreator $creator) : Response
    {
        $user =$login->__invoke($request->headers->get('Authorization'));
        if(!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $data = $request->toArray();
        $journal = $creator->__invoke(
            $user,
            $data['name'],
            $data['breed'],
            $data['age'],
            $data['gender'],
            $data['weight']
        );
       return new JsonResponse(
              [
                'message' => 'Journal created successfully!',
                'journal' => [
                     'id' => $journal->getId(),
                     'animal' => $journal->getAnimal()->__toString(),
                     ],
                  ],
           Response::HTTP_CREATED
       );
    }

}

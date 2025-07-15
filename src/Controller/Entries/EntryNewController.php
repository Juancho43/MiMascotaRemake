<?php

namespace App\Controller\Entries;

use App\MiMascota\Journals\Application\AddEntry;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryNewController extends AbstractController
{
    #[Route('/entry', name: 'entry_create', methods: ['POST'])]
    public function create(Request $request, CheckToken $login, AddEntry $creator) : Response
    {
        $user =$login->__invoke($request->headers->get('Authorization'));
        if(!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $data = $request->toArray();
        $entry = $creator->__invoke(
            $data['journal_id'],
            $data['title'],
            $data['content'],
            $data['date']
        );
        return new JsonResponse(
            [
                'message' => 'Entry created successfully!',
                'entry' => [
                    'id' => $entry->getId(),
                    'title' => $entry->getTitle(),
                    'content' => $entry->getContent(),
                    'date' => $entry->getDate()->format('Y-m-d H:i:s'),
//                    'journal' => [
//                        'id' => $entry->getJournal()->getId(),
//                        'animal' => $entry->getJournal()->getAnimal()->__toString(),
//                    ],
                ],
            ],
            Response::HTTP_CREATED
        );
    }
}

<?php

namespace App\Controller\Entries;

use App\MiMascota\Entries\Application\Command\EditEntryCommand;
use App\MiMascota\Entries\Application\DTO\EntryResponse;
use App\MiMascota\Entries\Application\EntryEdit;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryEditController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/entry/edit', name: 'entry_edit', methods: ['PUT'])]
    public function __invoke(Request $request, EntryEdit $entryEdit) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            if ($user->getId() !== $data['user_id']) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }
            $command = new EditEntryCommand(
                $data['id'],
                $data['title'],
                $data['content'],
                $data['date'],
                $data['user_id'],
            );
            $response = $entryEdit->__invoke($command);
            return $this->successResponse(EntryResponse::generate($response), 'Entry updated successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

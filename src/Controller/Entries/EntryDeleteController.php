<?php

namespace App\Controller\Entries;

use App\MiMascota\Entries\Application\Command\SoftDeleteEntryCommand;
use App\MiMascota\Entries\Application\EntrySoftDelete;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntryDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/entry/delete/{id}', name: 'entry_delete', methods: ['DELETE'])]
    public function __invoke(Request $request, EntrySoftDelete $entrySoftDelete, string $id) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $command = new SoftDeleteEntryCommand($id);
            $entrySoftDelete->__invoke($command);
            return $this->successResponse(null, 'Entry deleted successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

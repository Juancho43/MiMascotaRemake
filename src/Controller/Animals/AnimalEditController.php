<?php

namespace App\Controller\Animals;

use App\MiMascota\Animals\Application\AnimalEdit;
use App\MiMascota\Animals\Application\Command\EditAnimalCommand;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Journals\Application\DTO\JournalResponse;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Domain\Exceptions\UserPermissionDenied;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalEditController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/animal/edit', name: 'animal_edit', methods: ['PUT'])]
    public function __invoke(Request $request, AnimalEdit $animalEdit ) : Response
    {
        try {
            $user = $this->checkAuthorization($request);

            $data = $request->toArray();
            if ($user->getId() !== $data['user_id']){
                throw new UserPermissionDenied('to edit this animal');
            }
            $command = new EditAnimalCommand(
                $data['user_id'],
                $data['journal_id'],
                $data['name'],
                $data['description'],
                $data['color'],
                $data['size'],
                $data['breed'],
                $data['gender'],
                $data['birthdate'],
                $data['weight']
            );
            $animal = $animalEdit->__invoke($command);
            $journal = $animal->getJournal();
            return $this->successResponse(JournalResponse::generate($journal), 'Animal updated successfully');
        }catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}

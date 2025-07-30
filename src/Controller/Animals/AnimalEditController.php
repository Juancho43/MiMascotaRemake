<?php

namespace App\Controller\Animals;

use App\MiMascota\Animals\Application\AnimalEdit;
use App\MiMascota\Animals\Application\DTO\AnimalResponse;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
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
            $animal = $animalEdit->__invoke(
                $user,
                $data['journal_id'],
                $data['name'],
                $data['description'],
                $data['color'],
                $data['size'],
                $data['breed'],
                $data['gender'],
                new \DateTimeImmutable($data['birthdate']),
                $data['weight']
            );
            return $this->successResponse($animal, 'Animal updated successfully');
        }catch (\Exception $e) {
            return $this->errorResponse($e->getMessage() );
        }
    }
}

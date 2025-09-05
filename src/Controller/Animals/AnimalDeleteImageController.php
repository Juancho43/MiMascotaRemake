<?php

namespace App\Controller\Animals;

use App\MiMascota\Animals\Application\AnimalDeleteImage;
use App\MiMascota\Animals\Application\Command\DeleteAnimalImageCommand;
use App\MiMascota\Images\Application\Command\DeleteImageCommand;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalDeleteImageController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/animal/delete/image', name: 'animal_change_image', methods: ['PUT'])]
    public function __invoke(Request $request, AnimalDeleteImage $deleteImage) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new DeleteAnimalImageCommand($data['animal_id'],$data['image_id']);
            $deleteImage->__invoke($command);
            return $this->successResponse(message: 'Image deleted successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

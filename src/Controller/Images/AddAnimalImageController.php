<?php

namespace App\Controller\Images;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Animals\Application\Command\AddAnimalImageCommand;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddAnimalImageController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/animal/add/image', name: 'animal_add_image', methods: ['POST'])]
    public function __invoke(Request $request, AnimalAddImage $saveImage) : JsonResponse
    {
        try {

            $this->checkAuthorization($request);
            $data = ImageHelper::extractFormData($request);
            $uploadedFile = ImageHelper::extractUploadedFile($request);
            $command = new AddAnimalImageCommand(
                $data['animal_id'],
                $uploadedFile->getPathname(),
                $uploadedFile->getClientMimeType(),
                (string)$uploadedFile->getSize(),
                0
            );
             $saveImage->__invoke($command);
            return $this->successResponse(message:  'Picture uploaded successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}

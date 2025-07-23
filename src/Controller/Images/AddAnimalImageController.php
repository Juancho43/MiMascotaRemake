<?php

namespace App\Controller\Images;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Images\Application\SaveAnimalImage;
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
        $this->checkAuthorization($request);
        $response = [];
        $uploadedFiles = $request->files->all();
        if(count($uploadedFiles) > 0) {
            $position = 0;
            foreach ($uploadedFiles as $uploadedFile ) {
                $response[] = $saveImage->__invoke(
                    $uploadedFile,
                    $request->get('imageable_id',$request->get('animal_id')),
                    $position
                );
                $position++;
            }
        }

       return $this->successResponse($response,'Pictures uploaded successfully');
    }
}

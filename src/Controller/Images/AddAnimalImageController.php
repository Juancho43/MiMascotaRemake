<?php

namespace App\Controller\Images;

use App\MiMascota\Images\Application\SaveAnimalImage;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddAnimalImageController extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/animal/add/image', name: 'animal_add_image', methods: ['POST'])]
    public function __invoke(Request $request, SaveAnimalImage $saveImage)
    {
        $response = [];
        $uploadedFiles = $request->files->all();
        if(count($uploadedFiles) > 0) {
            foreach ($uploadedFiles as $uploadedFile) {
                $response[] = $saveImage->__invoke(
                    $uploadedFile,
                    $request->get('imageable_id',$request->get('animal_id'))
                );

            }
        }

        return $this->successResponse($response,'Pictures uploaded successfully');
    }
}

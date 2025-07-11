<?php

namespace App\Controller\Images;

use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddEntryImage extends AbstractController
{
    use ApiResponseTrait;
    #[Route('/entry/add/image', name: 'entry_add_image', methods: ['POST'])]
    public function upload(Request $request, SaveImage $saveImage)
    {
        $response = [];
        $uploadedFiles = $request->files->all();
        if(count($uploadedFiles) > 0) {
          foreach ($uploadedFiles as $uploadedFile) {
              $response[] = $saveImage->__invoke(
                $uploadedFile,
                $request->get('imageable_type', 'entry'),
                $request->get('imageable_id',$request->get('entry_id'))
            );

          }
        }

        return $this->successResponse($response,'Pictures uploaded successfully');
    }
}

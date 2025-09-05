<?php

namespace App\Controller\Images;

use App\MiMascota\Animals\Application\AnimalAddImage;
use App\MiMascota\Animals\Application\Command\AddAnimalImageCommand;
use App\MiMascota\Forums\Application\Command\AddForumImageCommand;
use App\MiMascota\Forums\Application\Query\ForumAddImage;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddForumImageController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/forums/add/image', name: 'forum_add_image', methods: ['POST'])]
    public function __invoke(Request $request, ForumAddImage $saveImage) : JsonResponse
    {
        try {

            $this->checkAuthorization($request);
            $data = ImageHelper::extractFormData($request);
            $uploadedFile = ImageHelper::extractUploadedFile($request);
            $command = new AddForumImageCommand(
                $data['forum_id'],
                $uploadedFile,

            );
             $saveImage->__invoke($command);
            return $this->successResponse(message:  'Image uploaded successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}

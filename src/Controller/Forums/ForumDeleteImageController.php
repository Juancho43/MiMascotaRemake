<?php

namespace App\Controller\Forums;

use App\MiMascota\Animals\Application\AnimalDeleteImage;
use App\MiMascota\Animals\Application\Command\DeleteAnimalImageCommand;
use App\MiMascota\Forums\Application\Command\DeleteForumImageCommand;
use App\MiMascota\Forums\Application\ForumDeleteImage;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Images\Application\Command\DeleteImageCommand;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumDeleteImageController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/forums/delete/image', name: 'forum_change_image', methods: ['PUT'])]
    public function __invoke(Request $request, ForumDeleteImage $deleteImage) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new DeleteForumImageCommand($data['forum_id']);
            $deleteImage->__invoke($command);
            return $this->successResponse(message: 'Image deleted successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

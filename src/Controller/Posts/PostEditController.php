<?php

namespace App\Controller\Posts;

use App\MiMascota\Posts\Application\Command\EditPostCommand;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\PostEdit;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostEditController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route ('/posts/edit', name: 'post_edit', methods: ['PUT'])]

    public function __invoke(Request $request, PostEdit $postEdit) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $location_id = $data['location_id'] != '' ?  $data['location_id']: $user->getUserLocation()->getLocation()->getId();
            $command = new EditPostCommand(
                $data['id'],
                $data['title'],
                $data['content'],
                $user->getId(),
                $location_id
            );
            $post = $postEdit->__invoke($command);
            return $this->successResponse(PostResponse::generate($post), 'Post Edited');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

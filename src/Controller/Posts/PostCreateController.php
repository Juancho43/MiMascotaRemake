<?php

namespace App\Controller\Posts;

use App\MiMascota\Posts\Application\Command\CreatePostCommand;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\PostCreator;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCreateController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route ('/posts/create', name: 'post_create', methods: ['POST']) ]
    public function __invoke(Request $request, PostCreator $creator) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $location_id = $data['location_id'] != '' ?  $data['location_id']: $user->getUserLocation()->getLocation()->getId();
            $command = new CreatePostCommand(
                $data['title'],
                $data['content'],
                $data['animal_id'],
                $data['forum_slug'],
                $user->getId(),
                $location_id
            );
            $post = $creator->__invoke($command);
            return $this->successResponse(PostResponse::generate($post), 'Post Created',Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

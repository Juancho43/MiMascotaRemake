<?php

namespace App\Controller\Posts;

use App\MiMascota\Posts\Application\Command\DeletePostCommand;
use App\MiMascota\Posts\Application\PostSoftDelete;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostSoftDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route ('/posts/{id}/soft-delete', name: 'post_soft_delete', methods: ['DELETE'])]
     public function __invoke(Request $request,string $id, PostSoftDelete $postSoftDelete) : Response
    {
        try {
            $this->checkAuthorization($request);
            $response = $postSoftDelete->__invoke(new DeletePostCommand($id));
            return $this->successResponse($response,'Post deleted successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

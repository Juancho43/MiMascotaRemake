<?php

namespace App\Controller\Posts;

use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostGetController extends AbstractController
{
    use ApiResponseTrait;
    #[Route ('/posts/{id}', name: 'post_get', methods: ['GET'])]
    public function __invoke(Request $request, string $id, PostGetById $getData) : Response
    {
        try {
            $query = new GetPostByIdQuery($id);
            return $this->successResponse(PostResponse::generate($getData->__invoke($query)),'Post retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

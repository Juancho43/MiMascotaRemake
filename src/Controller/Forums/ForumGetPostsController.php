<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumGetData;
use App\MiMascota\Forums\Application\ForumGetPosts;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumGetPostsController extends AbstractController
{
    use ApiResponseTrait;

    #[Route('/forums/{slug}/{page}/{limit}', name: 'forum_data', methods: ['GET'])]
    public function __invoke(string $slug,int $page,int $limit, ForumGetPosts $getPosts) : Response
    {
        try {
            $posts = $getPosts->__invoke($slug, $page, $limit);
            return $this->successResponse($posts,'Posts retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

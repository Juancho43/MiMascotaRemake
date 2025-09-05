<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Application\ForumGetPosts;
use App\MiMascota\Forums\Application\Query\GetForumPostBySlugPaginationQuery;
use App\MiMascota\Posts\Application\DTO\PostResponseCollection;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumGetPostsController extends AbstractController
{
    use ApiResponseTrait;

    #[Route('/forums/{slug}/{page}/{limit}', name: 'forum_posts', methods: ['GET'])]
    public function __invoke(string $slug,int $page,int $limit, ForumGetPosts $getPosts) : Response
    {
        try {
            $query = new GetForumPostBySlugPaginationQuery($slug, $page, $limit);
            $posts = $getPosts->__invoke($query);
            return $this->successResponse(PostResponseCollection::generate($posts),'Posts retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

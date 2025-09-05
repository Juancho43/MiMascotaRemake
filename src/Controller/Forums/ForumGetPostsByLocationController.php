<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Application\ForumGetPostByLocation;
use App\MiMascota\Forums\Application\ForumGetPosts;
use App\MiMascota\Forums\Application\Query\GetForumPostBySlugAndLocationPaginationQuery;
use App\MiMascota\Forums\Application\Query\GetForumPostBySlugPaginationQuery;
use App\MiMascota\Posts\Application\DTO\PostResponseCollection;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumGetPostsByLocationController extends AbstractController
{
    use ApiResponseTrait;

    #[Route('/forums/{slug}/{locationSlug}/{page}/{limit}', name: 'forum_by_locations_posts', methods: ['GET'])]
    public function __invoke(string $slug, string $locationSlug, int $page, int $limit, ForumGetPostByLocation $getPosts) : Response
    {
        try {
            $query = new GetForumPostBySlugAndLocationPaginationQuery($slug, $locationSlug, $page, $limit);
            $posts = $getPosts->__invoke($query);
            return $this->successResponse(PostResponseCollection::generate($posts),'Posts retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

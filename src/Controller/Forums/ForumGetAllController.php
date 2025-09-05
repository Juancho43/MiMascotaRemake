<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\DTO\ForumCollectionResponse;
use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumGetAll;
use App\MiMascota\Forums\Application\ForumGetBySlug;
use App\MiMascota\Forums\Application\Query\GetForumBySlugQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumGetAllController extends AbstractController
{
    use ApiResponseTrait;

    #[Route('/forums', name: 'forum_getAll', methods: ['GET'])]
    public function __invoke(ForumGetAll $forumGetData) : Response
    {
        try {
            return $this->successResponse(ForumCollectionResponse::generate($forumGetData->__invoke()),'Forum data retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

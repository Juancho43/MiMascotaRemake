<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumGetData;
use App\MiMascota\Shared\ApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumGetDataController extends AbstractController
{
    use ApiResponseTrait;

    #[Route('/forums/{slug}', name: 'forum_data', methods: ['GET'])]
    public function __invoke(string $slug, ForumGetData $forumGetData) : Response
    {
        try {
            $forum = $forumGetData->__invoke($slug);
            return $this->successResponse(ForumResponse::generate($forum),'Forum data retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

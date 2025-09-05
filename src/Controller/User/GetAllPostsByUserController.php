<?php

namespace App\Controller\User;


use App\MiMascota\Journals\Application\JournalGetAllData;
use App\MiMascota\Journals\Application\Query\GetAllJournalsByUserIdQuery;
use App\MiMascota\Posts\Application\DTO\PostResponseCollection;
use App\MiMascota\Posts\Application\PostsGetAllData;
use App\MiMascota\Posts\Application\Query\GetPostsByUserIdQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Shared\SerializerTrait;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllPostsByUserController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/posts', name: 'user_posts', methods: ['GET'])]
    public function __invoke(Request $request, PostsGetAllData $getData, int $page = 1, int $limit = 10):Response
    {
        try {
            $user = $this->checkAuthorization($request);

            $posts = $getData->__invoke(new GetPostsByUserIdQuery($user->getId(),$page,$limit));
//            dd($posts);
            return $this->successResponse(PostResponseCollection::generate($posts), 'Journals retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}

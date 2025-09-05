<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\Command\EditForumCommand;
use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumEdit;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumEditController extends AbstractController
{

    use ApiResponseTrait, AuthorizationCheckerTrait;

    #[Route('/forums/edit', name: 'forum_edit', methods: ['PUT'])]
    public function __invoke(Request $request,ForumEdit $forumEdit) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new EditForumCommand($data['id'],$data['name'],$data['description'],$user->getId());
            $response = $forumEdit->__invoke($command);
            return $this->successResponse(ForumResponse::generate($response), 'Forum updated successfully',);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

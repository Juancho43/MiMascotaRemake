<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumSoftDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('forums/delete/{id}', name: 'forum_soft_delete', methods: ['DELETE'])]
    public function __invoke(Request  $request,string $id ,ForumSoftDelete $forumSoftDelete) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $response = $forumSoftDelete->__invoke($id, $user);
            return $this->successResponse($response,'Forum deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

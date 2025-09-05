<?php

namespace App\Controller\Posts;

use App\MiMascota\Posts\Application\Command\ReportPostCommand;
use App\MiMascota\Posts\Application\DTO\PostResponse;
use App\MiMascota\Posts\Application\PostReport;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostReportController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;

    #[Route ('/posts/report', name: 'post_report', methods: ['PUT']) ]
    public function __invoke(Request $request, PostReport $postReport ) : Response
    {
        try{
            $this->checkAuthorization($request);
            $response = $postReport->__invoke(new ReportPostCommand($request->toArray()['id']));
            return $this->successResponse(PostResponse::generate($response), 'Post Reported');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}

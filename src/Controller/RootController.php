<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route(path:'api', name:'app_api_root')]
class RootController extends AbstractController
{
    #[Route(path:'/', name: 'app_api_root_index', methods:['GET'])]
    public function index(Request $request): JsonResponse
    {
        return $this->json(data: [
            'message' => 'server is running',
            'host' => $request->getHttpHost(),
            'protocol' => $request->getScheme(),
        ]);
    }

    #[Route(path:'/ping', name: 'app_api_root_ping', methods:['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json(data: [
            'message' => 'pong',
        ]);
    }
}

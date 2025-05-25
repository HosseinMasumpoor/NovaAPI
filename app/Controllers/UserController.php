<?php

namespace App\Controllers;

use App\Services\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController
{

    public function getUser(Request $request){
        $user = auth()->user();

        try {
            return successResponse($user, "");
        } catch (\Exception $e) {
            return failedResponse($e->getMessage());
        }

    }
}

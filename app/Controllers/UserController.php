<?php

namespace App\Controllers;

use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function __construct(protected UserService $service)
    {
    }

    public function getUser(Request $request){
        $user = auth()->user();

        try {
            return successResponse($user, "");
        } catch (\Exception $e) {
            return failedResponse($e->getMessage());
        }

    }

    public function updateProfile(Request $request){
        $user = auth()->user();

        $data = array_merge($request->request->all(), $request->files->all());

        $result = $this->service->updateProfile($user["id"], $data);
        if($result){
            return successResponse([], "");
        }
        return failedResponse("");
    }
}

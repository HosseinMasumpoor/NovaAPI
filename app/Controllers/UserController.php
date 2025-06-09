<?php

namespace App\Controllers;

use App\Core\Validation\ValidatorManager;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $rules = [
            'mobile' => 'required|string'
        ];

        $messages = [
            'mobile.required' => 'Mobile is required'
        ];



        $validator = app()->make(ValidatorManager::class);
        $result = $validator->driver('illuminate')->validate($data, $rules, $messages);

        if($result->failed()){
            return new JsonResponse($result->errors(), 401);
        }


        $result = $this->service->updateProfile($user["id"], $data);
        if($result){
            return successResponse([], "");
        }
        return failedResponse("");
    }

}

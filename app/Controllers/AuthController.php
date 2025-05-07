<?php

namespace App\Controllers;

use App\Services\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController
{
    public function __construct(protected AuthService $service){}

    public function login(Request $request){
        $mobile = $request->request->get('mobile');
        try {
            $this->service->sendOTP($mobile);
            return successResponse([], trans('auth.otp.success_sent'));
        } catch (\Exception $e) {
            return failedResponse($e->getMessage());
        }

    }

    public function verifyOTP(Request $request){
        $mobile = $request->request->get('mobile');
        $code = $request->request->get('code');

        $token = $this->service->verifyOTP($mobile, $code);
        if($token){
            return new JsonResponse([
                'success' => true,
                'token' => $token,
                'message' => trans('auth.login.success')
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'token' => null,
            'message' => trans('auth.login.error')
        ], Response::HTTP_INTERNAL_SERVER_ERROR);


    }
}

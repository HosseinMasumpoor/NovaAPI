<?php

namespace App\Controllers;

use App\Services\AuthService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function __construct(protected AuthService $service){}

    public function login(Request $request): JsonResponse
    {
        $mobile = $request->request->get('mobile');
        try {
            $this->service->sendOTP($mobile);
            return successResponse([], trans('auth.otp.success_sent'));
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }

    }

    public function verifyOTP(Request $request): JsonResponse
    {
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

    public function logout(Request $request): JsonResponse
    {
        $token = getAuthorizationToken();

        $result = $this->service->logout($token);
        if($result){
            return new JsonResponse([
                'success' => true,
                'data' => [],
                'message' => trans('auth.logout.success')
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'token' => null,
            'message' => trans('auth.logout.error')
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

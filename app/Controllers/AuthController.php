<?php

namespace App\Controllers;

use App\Services\AuthService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

        $result = $this->service->verifyOTP($mobile, $code);
        $data = [
            'access_token' => $result['accessToken'],
            'refresh_token' => $result['refreshToken'],
        ];

        if($result){
            return successResponse($data, trans('auth.login.success'));
        }

        return failedResponse(trans('auth.login.error'));
    }

    public function logout(Request $request): JsonResponse
    {
        $token = getAuthorizationToken();

        $result = $this->service->logout($token);
        if($result){
            return successResponse([], trans('auth.logout.success'));
        }

        return failedResponse(trans('auth.logout.error'));
    }

    public function refresh(Request $request): JsonResponse
    {
        $refreshToken = $request->get('refresh_token');
        $token = $this->service->refresh($refreshToken);
        $data = [
            'access_token' => $token,
        ];

        if($token){
            return successResponse($data, trans('auth.refresh.success'));
        }
        return failedResponse(trans('auth.refresh.error'));

    }
}

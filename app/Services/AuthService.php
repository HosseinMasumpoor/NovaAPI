<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\JWTAuth\JWTAuthService;
use Illuminate\Database\Eloquent\Model;

class AuthService
{
    public function __construct(protected UserRepository $userRepository, protected OTPService $otpService, protected  JWTAuthService $jwtAuthService){}

    public function sendOTP(string $mobile): array
    {
        return $this->otpService->send(convertToValidMobileNumber($mobile));
    }

    public function verifyOTP(string $mobile, string $otp): ?string
    {
        $mobile = convertToValidMobileNumber($mobile);
        $result = $this->otpService->verify($mobile, $otp);
        if($result){
            $user = $this->userRepository->findByField('mobile', $mobile);
            if(!$user){
                $user = $this->register(compact('mobile'));
            }
            return $this->jwtAuthService->login($user->id);

        }
        return null;
    }

    public function logout(string $token): bool
    {
        return $this->jwtAuthService->logout($token);
    }

    private function register(array $data): Model
    {
        return $this->userRepository->newItem($data);
    }
}

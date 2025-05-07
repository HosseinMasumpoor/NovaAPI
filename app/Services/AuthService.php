<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class AuthService
{
    public function __construct(protected UserRepository $userRepository, protected OTPService $otpService, protected  JWTService $jwtService){}

    public function sendOTP(string $mobile): array
    {
        return $this->otpService->send(convertToValidMobileNumber($mobile));
    }

    public function verifyOTP(string $mobile, string $otp){
        $mobile = convertToValidMobileNumber($mobile);
        $result = $this->otpService->verify($mobile, $otp);
        if($result){
            $user = $this->userRepository->findByField('mobile', $mobile);
            if(!$user){
                $user = $this->register(compact('mobile'));
            }

            return $this->jwtService->encode([
                'id' => $user->id
            ]);

        }
        return null;
    }

    private function register(array $data): Model
    {
        return $this->userRepository->newItem($data);
    }
}

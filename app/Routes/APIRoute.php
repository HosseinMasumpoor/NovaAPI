<?php

namespace App\Routes;

use App\Controllers\AuthController;
use App\Core\Routing\BaseRouter;

class APIRoute extends BaseRouter
{
    public function register(): void
    {
        $this->router->post('api.auth.login', '/api/auth/login', [AuthController::class, 'login']);
        $this->router->post('api.auth.verify-otp', '/api/auth/verify-otp', [AuthController::class, 'verifyOTP']);
    }
}

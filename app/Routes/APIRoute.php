<?php

namespace App\Routes;

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Core\Routing\BaseRouter;
use App\Middlewares\AuthMiddleware;

class APIRoute extends BaseRouter
{
    public function register(): void
    {
        $this->router->post('api.auth.login', '/api/auth/login', [AuthController::class, 'login']);
        $this->router->post('api.auth.verify-otp', '/api/auth/verify-otp', [AuthController::class, 'verifyOTP']);
        $this->router->post('api.auth.logout', '/api/auth/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
        $this->router->post('api.auth.refresh', '/api/auth/refresh', [AuthController::class, 'refresh']);
        $this->router->get('api.user', '/api/user', [UserController::class, 'getUser'], [AuthMiddleware::class]);
        $this->router->get('api.user.update-profile', '/api/user/update', [UserController::class, 'updateProfile'], [AuthMiddleware::class]);
    }
}

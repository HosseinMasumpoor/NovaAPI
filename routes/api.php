<?php

use App\Controllers\AuthController;
use App\Core\Router;

function registerAPIRoutes(Router $router): void
{
    $router->post('api.auth.login', '/api/auth/login', [AuthController::class, 'login']);
    $router->post('api.auth.verify-otp', '/api/auth/verify-otp', [AuthController::class, 'verifyOTP']);
}


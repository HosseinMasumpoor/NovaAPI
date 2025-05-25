<?php

namespace App\Middlewares;

use App\Core\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthMiddleware implements MiddlewareInterface
{

    public function handle(Request $request, callable $next)
    {
        if(auth()->check()) {
            return $next($request);
        }

        return new JsonResponse(['error' => 'Unauthorized'], 401);
    }
}

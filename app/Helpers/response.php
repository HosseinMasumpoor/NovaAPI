<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

if(!function_exists("successResponse")) {
    function successResponse(array $data = [], string $message = "", int $statusCode = 200): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }
}

if(!function_exists("failedResponse")) {
    function failedResponse(string $message = "", int $statusCode = 500): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}



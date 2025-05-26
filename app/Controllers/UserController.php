<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class UserController
{

    public function getUser(Request $request){
        $user = auth()->user();

        try {
            return successResponse($user, "");
        } catch (\Exception $e) {
            return failedResponse($e->getMessage());
        }

    }
}

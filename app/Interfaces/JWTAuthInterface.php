<?php

namespace App\Interfaces;

interface JWTAuthInterface
{
    public function logout(string $token, $exp) : bool;
    public function authenticate(string $token) : bool;
}

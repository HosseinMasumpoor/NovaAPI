<?php

namespace App\Core\Auth\Interfaces;

interface GuardInterface
{
    public function check(): bool;
    public function user(): ?array;
}

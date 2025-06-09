<?php

namespace App\Core\Validation\Contracts;

use App\Core\Validation\ValidationResult;

interface RuleInterface
{
    public function passes(string $attribute, mixed $value, array $data): bool;

    public function message(string $attribute): string;
}

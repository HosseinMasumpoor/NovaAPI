<?php

namespace App\Core\Validation;

class ValidationResult
{
    public function __construct(protected bool $isPassed, protected array $errors, protected array $validatedData = [])
    {
    }

    public function passed(): bool
    {
        return $this->isPassed;
    }

    public function failed(): bool
    {
        return !$this->isPassed;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validated(): array
    {
        return $this->validatedData;
    }
}

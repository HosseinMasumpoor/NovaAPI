<?php

namespace App\Core\Validation\Contracts;

use App\Core\Validation\ValidationResult;

interface ValidatorDriverInterface
{
    /**
     * Validate
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return ValidationResult
     */
    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = []): ValidationResult;
}

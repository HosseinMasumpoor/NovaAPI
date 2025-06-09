<?php

namespace App\Rules;

use App\Core\Validation\Contracts\RuleInterface;

class ValidMobileNumber implements RuleInterface
{

    public function passes(string $attribute, mixed $value, array $data): bool
    {
        $reg = "~^(0098|098|\+?98|0)9\d{9}$~";
        return (bool)preg_match($reg, $value);
    }

    public function message(string $attribute): string
    {
        return trans('messages.auth.errors.mobile_wrong');
    }
}

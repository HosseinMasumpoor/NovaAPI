<?php

namespace App\Core\Validation\Drivers;

use App\Core\Validation\Contracts\ValidatorDriverInterface;
use App\Core\Validation\ValidationResult;
use Rakit\Validation\Validator;

class RakitValidatorDriver implements ValidatorDriverInterface
{
    protected Validator $validator;

    public function __construct(array $config = [])
    {
        $this->validator = new Validator($config);
    }

    public function validate(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): ValidationResult
    {
        $validation = $this->validator->make($data, $rules, $messages);
        if (!empty($customAttributes)) {
            $validation->setAliases($customAttributes);
        }

        $validation->validate();

        return new ValidationResult(
            !$validation->fails(),
            $validation->errors()->firstOfAll(),
            $validation->getValidData()
        );
    }
}

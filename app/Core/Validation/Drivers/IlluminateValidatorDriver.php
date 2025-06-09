<?php

namespace App\Core\Validation\Drivers;


use App\Core\Validation\Contracts\ValidatorDriverInterface;
use App\Core\Validation\ValidationResult;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\Validator;


class IlluminateValidatorDriver implements ValidatorDriverInterface
{
    protected ValidatorFactory  $factory;

    public function __construct(array $config = [])
    {
        $loader = new ArrayLoader();
        $translator = new Translator($loader, $config['locale'] ?? config('app.locale'));

        $this->factory = new ValidatorFactory($translator);
    }

    public function validate(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): ValidationResult
    {
        /** @var Validator $validator */
        $validator = $this->factory->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return new ValidationResult(false, $validator->errors()->toArray(), []);
        }

        return new ValidationResult(true, [], $validator->validated());
    }
}

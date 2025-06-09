<?php

namespace App\Core\Validation\Drivers;

use App\Core\Validation\Contracts\RuleInterface;
use App\Core\Validation\Contracts\ValidatorDriverInterface;
use App\Core\Validation\ValidationResult;
use Rakit\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as V;

class RespectValidatorDriver implements ValidatorDriverInterface
{
    protected Validator $validator;

    public function __construct(array $config = [])
    {
        $this->validator = new Validator($config);
    }

    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = []): ValidationResult
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $validator = $this->convertRule($rule, $field, $data, $messages);

            try {
                $validator->assert($data[$field] ?? null);
            } catch (NestedValidationException $e) {
                $firstMessage = $this->extractFirstMessage($e);
                $errors[$field] = [$firstMessage];
            }
        }

        return new ValidationResult(empty($errors), $errors, $data);
    }

    protected function convertRule(array|string|Validatable|RuleInterface $rules, string $attribute, array $data, array $messages): Validatable
    {
        if ($rules instanceof Validatable) {
            return $rules;
        }

        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        $validators = [];

        foreach ($rules as $rule) {
            if ($rule instanceof RuleInterface) {
                $validators[] = $this->resolveCustomRule($rule, $attribute, $data);
            } else {
                $validators[] = $this->resolveRule($rule, $attribute, $messages);
            }
        }

        return V::allOf(...$validators);
    }

    private function resolveRule(string $rule, string $attribute, array $messages): Validatable
    {
        [$name, $params] = array_pad(explode(':', $rule, 2), 2, null);
        $paramList = $params ? explode(',', $params) : [];

        $key = "$attribute.$name";
        $customMessage = $messages[$key] ?? null;

        return match ($name) {
            'required' => V::notBlank()->setTemplate($customMessage ?? "The $attribute field is required."),
            'string'   => V::stringType()->setTemplate($customMessage ?? "The $attribute must be a string."),
            'min'      => V::length((int)$paramList[0], null)->setTemplate($customMessage ?? "The $attribute must be at least {$paramList[0]} characters."),
            'max'      => V::length(null, (int)$paramList[0])->setTemplate($customMessage ?? "The $attribute must not be greater than {$paramList[0]} characters."),
            'email'    => V::email()->setTemplate($customMessage ?? "The $attribute must be a valid email address."),
            default    => throw new \InvalidArgumentException("Unknown rule: $name")
        };
    }

    private function resolveCustomRule(RuleInterface $rule, string $attribute, array $data): Validatable
    {
        return V::callback(fn ($value) => $rule->passes($attribute, $value, $data))
            ->setTemplate($rule->message($attribute));
    }
    protected function extractFirstMessage(NestedValidationException $exception): string
    {
        $messages = array_filter($exception->getMessages(), fn ($msg) => !is_null($msg) && trim($msg) !== '');
        return array_values($messages)[0] ?? 'Invalid value.';
    }

}

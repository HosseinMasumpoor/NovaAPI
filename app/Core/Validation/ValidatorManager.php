<?php

namespace App\Core\Validation;

use InvalidArgumentException;

class ValidatorManager
{
    private string $driver;
    public function __construct(private readonly DriverRegistry $registry)
    {
        $this->driver = config('validation.default');
    }

    public function driver(string $name = null): self
    {
        if($name){
            if(!$this->registry->has($name)){
                throw new InvalidArgumentException("Validator driver [{$name}] is not registered.");
            }
            $this->driver = $name;
        }

        return $this;
    }

    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = [], ?string $driverName = null) : ValidationResult
    {
        $driverName = $driverName ?? $this->driver;
        $config = config('validation.drivers.'.$driverName);

        $driver = $this->registry->resolve($driverName, $config);
        return $driver->validate($data, $rules, $messages, $customAttributes);
    }
}

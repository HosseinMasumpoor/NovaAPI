<?php

namespace App\Core;

use App\Core\Exceptions\NotInstantiableClassException;
use Closure;
use mysql_xdevapi\Exception;
use ReflectionClass;
use ReflectionParameter;

class Container
{
    protected array $bindings = [];
    public function bind(string $abstract, Closure|string $concrete = null){
        if(!$concrete){
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, Closure|string $concrete = null){
        $this->bindings[$abstract] = function () use ($concrete) {
            static $instance;
            if(!$instance){
                $instance = $this->resolve($concrete);
            }

            return $instance;
        };
    }

    public function make(string $abstract){
        if(isset($this->bindings[$abstract])){
            $concrete = $this->bindings[$abstract];
            if($concrete instanceof Closure){
                return $concrete($this);
            }


            return $this->resolve($concrete);
        }

        return $this->resolve($abstract);
    }

    public function resolve(Closure|string $class){
        if ($class instanceof Closure) {
            return $class($this);
        }

        $reflector = new ReflectionClass($class);

        if(!$reflector->isInstantiable()){
            throw new NotInstantiableClassException("Class {$class} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if(!$constructor){
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->make($type->getName());
            } else {
                $dependencies[] = null;
            }
        }


        return $reflector->newInstanceArgs($dependencies);
    }
}

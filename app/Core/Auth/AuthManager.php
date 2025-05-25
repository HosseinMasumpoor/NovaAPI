<?php

namespace App\Core\Auth;

use App\Core\Auth\Interfaces\GuardInterface;
use App\Core\Exceptions\AuthException;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthManager
{
    protected array $guards = [];

    public function __construct(private readonly DriverRegistry $driverRegistry)
    {
    }

    public function guard(?string $name): ?GuardInterface
    {
        $name = $name ?? $this->getDefaultGuard();
        if(!isset($this->guards[$name])) {
            return $this->resovleGuard($name);
        }

        return $this->guards[$name];
    }

    private function getDefaultGuard(): string
    {
        return config('auth.defaults.guard');
    }

    private function resovleGuard(string $name)
    {
        $config = config('auth.guards.'.$name);
        if(!$config)
        {
            throw new AuthException('Guard '.$name.' not found');
        }

        $driverName = $config['driver'];
        $providerName = $config['provider'];

        $providerConfig = config('auth.providers.'.$providerName);

        $model = $providerConfig['model'];

        $factory = $this->driverRegistry->getDriverFactory($driverName);

        return $factory($config, $model);
    }

}

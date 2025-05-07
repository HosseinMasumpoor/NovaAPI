<?php

namespace App\Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;


class Eloquent implements DatabaseInterface
{
    protected Capsule $capsule;
    public function __construct()
    {
        $this->capsule = new Capsule();
        $this->setConnection();
        $this->setDefaultConnection();
    }

    public function connect(): void
    {
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    private function setConnection(): void
    {
        $drivers = config('database.drivers');
        foreach ($drivers as $driver => $config) {
            $this->capsule->addConnection($config, $driver);
        }
    }

    private function setDefaultConnection(): void
    {
        $default = config('database.default_driver');
        $this->capsule->getDatabaseManager()->setDefaultConnection($default);
    }

}

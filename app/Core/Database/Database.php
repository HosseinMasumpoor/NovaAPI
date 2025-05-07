<?php

namespace App\Core\Database;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQL\TcpConnectionConfig as MySQLTcpConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\Config\Postgres\TcpConnectionConfig as PostgresTcpConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\Config\SQLServer\TcpConnectionConfig as SQLServerTcpConnectionConfig;
use Cycle\Database\Config\SQLServerDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Config\SQLiteDriverConfig;


class Database
{
    public function connect(): DatabaseManager
    {
        return new DatabaseManager(new DatabaseConfig([
            'databases' => [
                'default' => ['connection' => 'mysql']
            ],
            'connections' => $this->connections()
        ]));
    }

    private function connections(): array
    {
        return [
            'sqlite' => new SQLiteDriverConfig(
                connection: new \Cycle\Database\Config\SQLite\FileConnectionConfig(
                    database: __DIR__.'/../../database/database.sqlite'
                )
            ),
            'mysql' => new MySQLDriverConfig(
                connection: new MySQLTcpConnectionConfig(
                    database: $_ENV['DB_NAME'],
                    host: $_ENV['DB_HOST'],
                    port: $_ENV['DB_PORT'],
                    user: $_ENV['DB_USER'],
                    password: $_ENV['DB_PASSWORD'],
                ),
                queryCache: true
            ),
            'postgres' => new PostgresDriverConfig(
                connection: new PostgresTcpConnectionConfig(
                    database: 'php-auth',
                    host: '127.0.0.1',
                    port: 5432,
                    user: 'root',
                    password: '',
                ),
                schema: 'public',
                queryCache: true,
            ),
            'sqlServer' => new SQLServerDriverConfig(
                connection: new SQLServerTcpConnectionConfig(
                    database: 'php-auth',
                    host: '127.0.0.1',
                    port: 5432,
                    user: 'spiral',
                    password: '',
                ),
                queryCache: true,
            ),
        ];
    }
}

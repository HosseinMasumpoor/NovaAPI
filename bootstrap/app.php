<?php

use App\Core\Container;
use App\Core\Database\DatabaseInterface;
use App\Core\Database\Eloquent;
use App\Core\Queue\Interfaces\QueueRepositoryInterface;
use App\Core\Queue\Repositories\EloquentQueueRepository;
use App\Core\Router;
use App\Interfaces\SendOTPInterface;
use App\Services\SendOTP\AmootSendOTP;
use Symfony\Component\HttpFoundation\Request;

class App
{
    protected Router $router;
    protected DatabaseInterface $db;
    protected Container $container;

    public function __construct()
    {
        $this->setBasePath();
        $this->loadEnv();
        $this->initContainer();
        $this->registerHelpers();
        $this->registerRoutes();
        $this->connectDatabase();
    }

    public function run(): void
    {
        $request = $this->container->make(Request::class);
        $response = $this->router->dispatch($request);
        $response->send();
    }

    private function setBasePath(): void
    {
        $GLOBALS["basePath"] = dirname(__DIR__);
    }

    protected function loadEnv(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    protected function initContainer(): void
    {
        $request = Request::createFromGlobals();

        $this->router = new Router();
        $this->container = new Container();

        $this->router->setContainer($this->container);

        $this->container->bind(SendOTPInterface::class, AmootSendOTP::class);
        $this->container->singleton(DatabaseInterface::class, Eloquent::class);
        $this->container->singleton(Router::class, fn()=> $this->router);
        $this->container->singleton(Request::class, fn()=> $request);
        $this->container->singleton(QueueRepositoryInterface::class, EloquentQueueRepository::class);

        $GLOBALS["app"] = $this->container;
    }

    protected function registerRoutes(): void
    {
        require_once __DIR__ . '/../routes/web.php';
        require_once __DIR__ . '/../routes/api.php';

        registerWebRoutes($this->router);
        registerAPIRoutes($this->router);
    }

    protected function registerHelpers(): void
    {
        require_once __DIR__ . '/../app/Helpers/core.php';
        require_once __DIR__ . '/../app/Helpers/message.php';
        require_once __DIR__ . '/../app/Helpers/convert.php';
        require_once __DIR__ . '/../app/Helpers/response.php';
    }

    protected function connectDatabase(): void
    {
        $database = $this->container->make(DatabaseInterface::class);
        $database->connect();
    }
}

<?php

use App\Core\Auth\AuthManager;
use App\Core\Container;
use App\Core\Database\DatabaseInterface;
use App\Core\Database\Eloquent;
use App\Core\Queue\Interfaces\QueueRepositoryInterface;
use App\Core\Queue\Repositories\EloquentQueueRepository;
use App\Core\Routing\Router;
use App\Interfaces\SendOTPInterface;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\StorageServiceProvider;
use App\Routes\APIRoute;
use App\Routes\WebRoute;
use App\Services\SendOTP\AmootSendOTP;
use Symfony\Component\HttpFoundation\Request;

class App
{
    protected Router $router;
    protected DatabaseInterface $db;
    protected Container $container;
    protected array $providers;

    public function __construct()
    {
        $this->setBasePath();
        $this->loadEnv();
        $this->initContainer();
        $this->setServiceProviders();
        $this->registerRoutes();
        $this->connectDatabase();
    }

    public function run(): void
    {
        $request = $this->container->make(Request::class);
        $GLOBALS["request"] = $request;
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
        $this->container->singleton(Container::class, fn()=> $this->container);
        $this->container->singleton(\App\Core\Auth\AuthManager::class, AuthManager::class);

        $GLOBALS["app"] = $this->container;
    }

    protected function registerRoutes(): void
    {
        $routes = [
            new APIRoute($this->router),
            new WebRoute($this->router),
        ];

        foreach ($routes as $route) {
            $route->register();
        }
    }

    protected function connectDatabase(): void
    {
        $database = $this->container->make(DatabaseInterface::class);
        $database->connect();
    }

    private function setServiceProviders(): void
    {
        $this->providers = [
            AppServiceProvider::class,
            AuthServiceProvider::class,
            StorageServiceProvider::class,
        ];

        $this->registerProviders();
        $this->bootProviders();
    }

    private function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider = $this->container->make($provider);
            $provider->register();
        }
    }

    private function bootProviders(): void
    {
        foreach($this->providers as $provider) {
            $provider = $this->container->make($provider);
            $provider->boot();
        }
    }
}

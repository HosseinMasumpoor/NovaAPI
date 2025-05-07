<?php

use App\Core\Container;
use App\Core\Database\DatabaseInterface;
use App\Core\Database\Eloquent;
use App\Core\Router;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Registry;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class App
{
    protected Router $router;
    protected DatabaseInterface $db;
    protected Container $container;

    public function __construct()
    {
        $this->loadEnv();
        $this->initContainer();
        $this->registerRoutes();
        $this->registerHelpers();
        $this->connectDatabase();
    }

    public function run(): void
    {
        $request = $this->container->make(Request::class);
        $response = $this->router->dispatch($request);
        $response->send();
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

        $this->container->singleton(DatabaseInterface::class, Eloquent::class);
        $this->container->singleton(Router::class, fn()=> $this->router);
        $this->container->singleton(Request::class, fn()=> $request);

        $GLOBALS["app"] = $this->container;
    }

    protected function registerRoutes(): void
    {
        require_once '../routes/web.php';
        require_once '../routes/api.php';

        registerWebRoutes($this->router);
        registerAPIRoutes($this->router);
    }

    protected function registerHelpers(): void
    {
        require_once '../app/Helpers/core.php';
        require_once '../app/Helpers/message.php';
        require_once '../app/Helpers/convert.php';
        require_once '../app/Helpers/response.php';
    }

    protected function connectDatabase(): void
    {
        $database = $this->container->make(DatabaseInterface::class);
        $database->connect();
    }
}

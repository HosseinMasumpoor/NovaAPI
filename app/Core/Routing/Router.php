<?php

namespace App\Core\Routing;

use App\Core\Container;
use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private RouteCollection $routes;
    private Container $container;
    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function get(string $name, string $path, array $controller, array $middlewares = []): void
    {
        $this->add($name, $path, $controller, 'GET', $middlewares);
    }

    public function post(string $name, string $path, array $controller, array $middlewares = []): void
    {
        $this->add($name, $path, $controller, 'POST', $middlewares);
    }

    public function put(string $name, string $path, array $controller, array $middlewares = []): void
    {
        $this->add($name, $path, $controller, 'PUT', $middlewares);
    }

    public function patch(string $name, string $path, array $controller, array $middlewares = []): void
    {
        $this->add($name, $path, $controller, 'PATCH', $middlewares);
    }

    public function delete(string $name, string $path, array $controller, array $middlewares = []): void
    {
        $this->add($name, $path, $controller, 'DELETE', $middlewares);
    }

    private function add(string $name, string $path, array $controller, string $method = 'GET', array $middlewares = []): void
    {
        $this->routes->add($name,new Route($path, [
            '_controller' => $controller,
            '_method' => strtoupper($method),
            '_middlewares' => $middlewares
        ]));
    }

    public function dispatch(Request $request){
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $parameters =  $matcher->match($request->getPathInfo());
            [$controllerClass, $method] = $parameters['_controller'];

            $middlewares = $parameters['_middlewares'] ?? [];

            $controller = $this->container ? $this->container->make($controllerClass) : new $controllerClass();


            $coreHandler = function(Request $request) use ($controller, $method) {
                return $controller->$method($request);
            };

            return $this->applyMiddlewares($request, $middlewares, $coreHandler);

        }catch (ResourceNotFoundException){
            return new Response('404 Not Found', 404);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }

    }

    private function applyMiddlewares(Request $request, mixed $middlewares, Closure $coreHandler)
    {
        $middlewares = array_reverse($middlewares);

        $dispatcher = array_reduce(
            $middlewares,
            function($next, $middlewareClass){
                return function ($request) use ($middlewareClass, $next) {
                    $middleware = $this->container->make($middlewareClass);
                    return $middleware->handle($request, $next);
                };
            },
            $coreHandler
        );

        return $dispatcher($request);
    }
}

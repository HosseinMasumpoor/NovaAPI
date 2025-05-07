<?php

namespace App\Core;

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

    public function get(string $name, string $path, array $controller): void
    {
        $this->add($name, $path, $controller, 'GET');
    }

    public function post(string $name, string $path, array $controller): void
    {
        $this->add($name, $path, $controller, 'POST');
    }

    public function put(string $name, string $path, array $controller): void
    {
        $this->add($name, $path, $controller, 'PUT');
    }

    public function patch(string $name, string $path, array $controller): void
    {
        $this->add($name, $path, $controller, 'PATCH');
    }

    public function delete(string $name, string $path, array $controller): void
    {
        $this->add($name, $path, $controller, 'DELETE');
    }

    private function add(string $name, string $path, array $controller, string $method = 'GET'): void
    {
        $this->routes->add($name,new Route($path, [
            '_controller' => $controller,
            '_method' => strtoupper($method)
        ]));
    }

    public function dispatch(Request $request){
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $parameters =  $matcher->match($request->getPathInfo());
            [$controllerClass, $method] = $parameters['_controller'];

            if($this->container){
                $controller = $this->container->make($controllerClass);
            }else{
                $controller = new $controllerClass();
            }

            return $controller->$method($request);
        }catch (ResourceNotFoundException $e){
            return new Response('404 Not Found', 404);
        } catch (\Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }

    }
}

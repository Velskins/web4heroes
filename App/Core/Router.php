<?php
namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    private ?Container $container = null;

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->method();
        $path   = $request->path();

        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            return new Response('Not Found', 404);
        }

        [$class, $action] = $handler;

        $controller = $this->container
            ? $this->container->make($class, $request)
            : new $class($request);

        return $controller->$action();
    }
}

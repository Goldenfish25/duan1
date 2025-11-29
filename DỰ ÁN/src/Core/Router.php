<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $currentGroupPrefix = '';

    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $previous = $this->currentGroupPrefix;
        $this->currentGroupPrefix = rtrim($previous . '/' . trim($prefix, '/'), '/');
        $callback($this);
        $this->currentGroupPrefix = $previous;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path = $request->path();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                array_shift($matches);
                $request->setRouteParams($matches);

                $action = $route['action'];

                if (is_array($action)) {
                    [$controller, $method] = $action;
                    $instance = new $controller();
                    call_user_func_array([$instance, $method], [$request]);
                } else {
                    call_user_func_array($action, [$request]);
                }

                return;
            }
        }

        http_response_code(404);
        echo View::render('errors/404');
    }

    private function addRoute(string $method, string $uri, callable|array $action): void
    {
        $uri = '/' . trim($this->currentGroupPrefix . '/' . trim($uri, '/'), '/');
        $pattern = $this->createPattern($uri);

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'action' => $action,
        ];
    }

    private function createPattern(string $uri): string
    {
        $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }
}


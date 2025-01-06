<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri)
    {
        // Debug
        error_log("Dispatching: $method $uri");

        foreach ($this->routes as $route) {
            error_log("Checking route: {$route['method']} {$route['path']}");

            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                error_log("Route matched!");
                [$controller, $action] = $route['handler'];

                if (!class_exists($controller)) {
                    throw new \Exception("Controller class not found: $controller");
                }

                $controllerInstance = new $controller();

                if (!method_exists($controllerInstance, $action)) {
                    throw new \Exception("Action not found in controller: $action");
                }

                if (preg_match('/^\/projects\/(\d+)$/', $uri, $matches) || preg_match('/^\/projects\/(\d+)\/([a-zA-Z]+)$/', $uri, $matches)) {
                    $id = (int)$matches[1];
                    return $controllerInstance->$action($id);
                } else {
                    return $controllerInstance->$action();
                }
            }
        }

        // Route non trouvée
        error_log("No route found for: $method $uri");
        $this->notFound();
    }

    private function notFound()
    {
        http_response_code(404);
        include VIEW_PATH . '/errors/404.php';
        exit();
    }

    private function matchPath(string $routePath, string $uri): bool
    {
        $routePath = preg_replace('/{[^}]+}/', '([^/]+)', $routePath);
        $match = preg_match("#^$routePath$#", $uri);
        error_log("Matching '$uri' against pattern '$routePath': " . ($match ? 'true' : 'false'));
        return $match;
    }
}

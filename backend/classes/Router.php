<?php
/**
 * File: /backend/classes/Router.php
 * Description: Lightweight, clean URL router mapping paths to controllers without extensions or IDs in URLs.
 */

declare(strict_types=1);

class Router {
    private array $routes = [];

    /**
     * Map a GET request to a controller action
     */
    public function get(string $path, array $handler): void {
        $this->routes['GET'][$this->sanitizePath($path)] = $handler;
    }

    /**
     * Map a POST request to a controller action
     */
    public function post(string $path, array $handler): void {
        $this->routes['POST'][$this->sanitizePath($path)] = $handler;
    }

    /**
     * Dispatch the route matching the clean request path
     */
    public function dispatch(string $requestedPath): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $cleanPath = $this->sanitizePath($requestedPath);

        if (isset($this->routes[$method][$cleanPath])) {
            [$controllerName, $action] = $this->routes[$method][$cleanPath];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        // Clean 404 Fallback
        $this->notFound();
    }

    private function sanitizePath(string $path): string {
        return trim($path, '/');
    }

    private function notFound(): void {
        http_response_code(404);
        echo "<h1 style='text-align:center; font-family:sans-serif; margin-top:20%;'>404 - Page Not Found</h1>";
        echo "<p style='text-align:center; font-family:sans-serif;'><a href='/'>Go back to Rentora PH Landing Page</a></p>";
    }
}
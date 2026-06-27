<?php
/**
 * File Location: backend/classes/Router.php
 * File Name: Router.php
 * Description: Light, readable URL routing engine resolving path actions to Controller classes.
 */

namespace App\Classes;

class Router {
    private array $routes = [];

    /**
     * Map GET requests
     */
    public function get(string $path, array|callable $callback): void {
        $this->routes['GET'][$this->sanitizePath($path)] = $callback;
    }

    /**
     * Map POST requests
     */
    public function post(string $path, array|callable $callback): void {
        $this->routes['POST'][$this->sanitizePath($path)] = $callback;
    }

    /**
     * Match and resolve incoming request
     */
    public function resolve(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Strip out query parameters if they exist
        $path = parse_url($uri, PHP_URL_PATH);
        $path = $this->sanitizePath($path);

        $callback = $this->routes[$method][$path] ?? null;

        if ($callback === null) {
            header("HTTP/1.1 404 Not Found");
            $errorPage = __DIR__ . '/../../frontend/views/errors/404.php';
            if (file_exists($errorPage)) {
                require_once $errorPage;
            } else {
                echo "<h1>404 Not Found</h1><p>The page you requested does not exist.</p>";
            }
            exit;
        }

        // Execute Callback
        if (is_callable($callback)) {
            call_user_func($callback);
            return;
        }

        if (is_array($callback)) {
            $controllerClass = $callback[0];
            $methodName = $callback[1];

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $methodName)) {
                    call_user_func([$controller, $methodName]);
                    return;
                }
            }
        }

        // Invalid callback configuration
        header("HTTP/1.1 500 Internal Server Error");
        echo "<h1>500 Internal Server Error</h1><p>Invalid route configuration.</p>";
    }

    /**
     * Normalize paths to ensure matching works seamlessly
     */
    private function sanitizePath(string $path): string {
        $path = trim($path, '/');
        return $path === '' ? '/' : '/' . $path;
    }
}
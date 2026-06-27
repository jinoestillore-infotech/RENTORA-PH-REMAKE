<?php
/**
 * File Location: index.php
 * File Name: index.php
 * Description: The primary bootstrapper and entry point of RENTORA PH. Configures custom autoloading, establishes session safeguards, and delegates routing.
 */

// 1. Register PSR-4 Autoloader mapping "App\" namespace to "backend/" directory
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/backend/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Classes\Session;
use App\Classes\Router;
use App\Classes\CSRF;

// 2. Start secure session
Session::start();

// 3. Clean and resolve URLs for subfolder installations (e.g., localhost/rentora-ph/)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? ''; 
$requestUri = $_SERVER['REQUEST_URI'] ?? ''; 

$basePath = str_replace('\\', '/', dirname($scriptName)); 
$baseUrl = $basePath === '/' ? '' : $basePath;

// Define globally accessible BASE_URL constant for safe views routing
define('BASE_URL', $baseUrl);

if ($basePath !== '/' && strpos($requestUri, $basePath) === 0) {
    // Strip "/rentora-ph" prefix so the Router parses virtual paths like "/" or "/register" cleanly
    $_SERVER['REQUEST_URI'] = substr($requestUri, strlen($basePath));
}

// 4. Initialize Router
$router = new Router();

// 5. Define Routing Actions

// Root route redirects users directly to /landing
$router->get('/', function() {
    header('Location: ' . BASE_URL . '/landing');
    exit;
});

// Landing page route
$router->get('/landing', function() {
    require_once __DIR__ . '/frontend/views/landing/index.php';
});

// Fire routing resolution engine
$router->resolve();
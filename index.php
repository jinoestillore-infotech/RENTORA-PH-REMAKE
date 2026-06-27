<?php
/**
 * File: /index.php
 * Description: Front Controller that bootstraps Rentora PH and handles all incoming requests.
 */

declare(strict_types=1);

session_start();

// Load Config
require_once __DIR__ . '/backend/config/config.php';

// Auto-register clean router/classes
require_once __DIR__ . '/backend/classes/Router.php';
require_once __DIR__ . '/backend/controllers/HomeController.php';
require_once __DIR__ . '/backend/controllers/RegistrationController.php';

// Initialize Router
$router = new Router();

// Load Web Routes
require_once __DIR__ . '/backend/routes/web.php';

// Dispatch routing based on URL path query parameter provided by .htaccess
$routePath = $_GET['route'] ?? '';
$router->dispatch($routePath);
<?php
/**
 * File: /backend/routes/web.php
 * Description: Contains web routes mapping clean URLs to corresponding Controller handlers.
 */

// Landing Page Route
$router->get('', [HomeController::class, 'index']);

// Registration clean paths (No extensions like .html or .php)
$router->get('register-owner', [RegistrationController::class, 'showOwnerForm']);
$router->post('register-owner', [RegistrationController::class, 'handleOwnerRegistration']);

$router->get('register-tenant', [RegistrationController::class, 'showTenantForm']);
$router->post('register-tenant', [RegistrationController::class, 'handleTenantRegistration']);
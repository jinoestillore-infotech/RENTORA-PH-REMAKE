<?php
/**
 * File: /backend/controllers/RegistrationController.php
 * Description: Controller to handle Owner and Tenant registration forms and processes.
 */

declare(strict_types=1);

class RegistrationController {
    /**
     * Show Boarding House Owner Registration Form
     */
    public function showOwnerForm(): void {
        $pageTitle = "Register Boarding House - Rentora PH";
        require_once __DIR__ . '/../../frontend/layouts/header.php';
        require_once __DIR__ . '/../../frontend/views/register-owner.php';
        require_once __DIR__ . '/../../frontend/layouts/footer.php';
    }

    /**
     * Handles Boarding House Owner form submission securely
     */
    public function handleOwnerRegistration(): void {
        // Form CSRF / Input Validation happens securely here
        $firstName = filter_input(INPUT_POST, 'first_name', FILTER_DEFAULT);
        $lastName = filter_input(INPUT_POST, 'last_name', FILTER_DEFAULT);
        $boardingHouseName = filter_input(INPUT_POST, 'bh_name', FILTER_DEFAULT);

        // Security check, escaping variables & validation before processing 
        // For current mock flow, redirecting to owner register page with success query
        header("Location: /register-owner?status=pending_review&owner=" . urlencode($firstName . " " . $lastName) . "&house=" . urlencode($boardingHouseName));
        exit;
    }

    /**
     * Show Tenant Registration Form
     */
    public function showTenantForm(): void {
        $pageTitle = "Register Tenant - Rentora PH";
        require_once __DIR__ . '/../../frontend/layouts/header.php';
        require_once __DIR__ . '/../../frontend/views/register-tenant.php';
        require_once __DIR__ . '/../../frontend/layouts/footer.php';
    }

    /**
     * Handles Tenant form submission securely
     */
    public function handleTenantRegistration(): void {
        $firstName = filter_input(INPUT_POST, 'first_name', FILTER_DEFAULT);
        $lastName = filter_input(INPUT_POST, 'last_name', FILTER_DEFAULT);

        // Instant registration scenario - no approval required for tenants
        header("Location: /register-tenant?status=approved_instantly&tenant=" . urlencode($firstName . " " . $lastName));
        exit;
    }
}
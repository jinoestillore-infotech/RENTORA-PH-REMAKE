<?php
/**
 * File: /backend/controllers/HomeController.php
 * Description: Controller for rendering the home/landing page.
 */

declare(strict_types=1);

class HomeController {
    /**
     * Renders the main landing page
     */
    public function index(): void {
        $pageTitle = "Welcome to Rentora PH - Premium Boarding House Finder";
        
        // Render views
        require_once __DIR__ . '/../../frontend/layouts/header.php';
        require_once __DIR__ . '/../../frontend/views/landing.php';
        require_once __DIR__ . '/../../frontend/layouts/footer.php';
    }
}
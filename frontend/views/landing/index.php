<?php
/**
 * File Location: frontend/views/landing/index.php
 * File Name: index.php
 * Description: Clean, modern, and fully responsive landing page introducing RENTORA PH with route-aware action links.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTORA PH - Boarding House Finder & Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Minimal custom styling for fine-tuning hero heights without over-riding Bootstrap */
        .hero-section {
            min-height: 75vh;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold tracking-wide text-uppercase" href="<?php echo BASE_URL; ?>/landing">
                RENTORA <span class="text-primary">PH</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-3 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>/landing">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item w-100 w-lg-auto">
                        <a class="btn btn-outline-light btn-sm px-4 py-2 w-100" href="<?php echo BASE_URL; ?>/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero / Introduction Section -->
    <main class="container my-auto py-5 hero-section d-flex align-items-center">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-semibold">Your Next Home Awaits</span>
                <h1 class="display-4 fw-bold lh-sm text-dark mb-3">
                    Find and Manage Boarding Houses in <span class="text-primary">One Platform</span>
                </h1>
                <p class="lead text-secondary mb-4">
                    RENTORA PH simplifies accommodation hunting for tenants and automates daily operations, tenant vetting, and payment tracking for boarding house owners. Built secure, fast, and organized.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="<?php echo BASE_URL; ?>/register-owner" class="btn btn-primary btn-lg px-4 py-3 fw-semibold shadow-sm">
                        Register Boarding House
                    </a>
                    <a href="<?php echo BASE_URL; ?>/register-tenant" class="btn btn-outline-dark btn-lg px-4 py-3 fw-semibold">
                        Register Tenant
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6">
                <!-- Informational Feature Cards Panel acting as system introduction -->
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="card h-100 border-0 shadow-sm p-3">
                            <div class="card-body">
                                <div class="text-primary mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-house-check-fill" viewBox="0 0 16 16">
                                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                                        <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                                        <path d="m12.146 8.146-3.5 3.5a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8.5 10.793l3.146-3.147a.5.5 0 0 1 .708.708z"/>
                                    </svg>
                                </div>
                                <h5 class="fw-bold">Verified Spaces</h5>
                                <p class="text-muted small mb-0">All properties pass manual document approval processes to assure real listings.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card h-100 border-0 shadow-sm p-3">
                            <div class="card-body">
                                <div class="text-primary mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2m0 1v5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1z"/>
                                    </svg>
                                </div>
                                <h5 class="fw-bold">Role Access (RBAC)</h5>
                                <p class="text-muted small mb-0">Secured dashboard parameters isolating admins, owners, and individual tenants cleanly.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="about" class="card border-0 shadow-sm p-3 bg-white">
                            <div class="card-body">
                                <h5 class="fw-bold text-dark">About the Platform</h5>
                                <p class="text-secondary small mb-0">
                                    RENTORA PH bridges the logistical gap within local rental sectors. It offers structural clarity for owners seeking validation and optimization alongside automated tools for tenants checking rates, managing amenities, and completing payments smoothly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white-50 py-3 mt-auto border-top border-secondary">
        <div class="container text-center">
            <small>&copy; 2026 RENTORA PH. All Rights Reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
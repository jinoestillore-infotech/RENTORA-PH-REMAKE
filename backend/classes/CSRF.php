<?php
/**
 * File Location: backend/classes/CSRF.php
 * File Name: CSRF.php
 * Description: Simple, cryptographically secure CSRF protection mechanics for forms.
 */

namespace App\Classes;

class CSRF {
    /**
     * Generate a cryptographically secure token and save it to the session.
     */
    public static function generateToken(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Validate the provided token against the session-stored token.
     */
    public static function validate(?string $token): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }

        // Mitigate timing attacks
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Echoes a secure hidden input field with the CSRF token.
     */
    public static function insertField(): void {
        $token = self::generateToken();
        echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
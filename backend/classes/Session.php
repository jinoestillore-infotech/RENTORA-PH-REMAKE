<?php
/**
 * File Location: backend/classes/Session.php
 * File Name: Session.php
 * Description: Simple and secure session utility ensuring cookie protection and session validity.
 */

namespace App\Classes;

class Session {
    /**
     * Start session with strict, secure configuration parameters.
     */
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 86400, // 24 hours
                'cookie_secure'   => isset($_SERVER['HTTPS']),
                'cookie_httponly' => true,
                'cookie_samesite' => 'Lax'
            ]);
        }

        // Session Regeneration (prevents Session Fixation attacks)
        if (!isset($_SESSION['created_time'])) {
            $_SESSION['created_time'] = time();
        } elseif (time() - $_SESSION['created_time'] > 1800) { // regenerate every 30 mins
            session_regenerate_id(true);
            $_SESSION['created_time'] = time();
        }
    }

    /**
     * Set a session variable
     */
    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session variable with fallback support
     */
    public static function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if a session variable exists
     */
    public static function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a session variable
     */
    public static function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    /**
     * Securely destroy the session (for logouts)
     */
    public static function destroy(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
        }
    }
}
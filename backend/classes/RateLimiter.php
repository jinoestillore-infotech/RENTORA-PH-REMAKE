<?php
/**
 * File Location: backend/classes/RateLimiter.php
 * File Name: RateLimiter.php
 * Description: Clean, session-backed application rate limiting to protect critical actions like logins.
 */

namespace App\Classes;

class RateLimiter {
    /**
     * Standard implementation checking if the client has exceeded request counts in a specified time block.
     * Use session limits to avoid database round trips on rapid-fire requests.
     * * @param string $action Key identifying the rate-limited transaction (e.g., 'login', 'register')
     * @param int $maxAttempts The maximum limit of requests allowed
     * @param int $decaySeconds Timeframe in seconds before attempts reset
     * @return bool True if the request is allowed, False if the request has been rate limited
     */
    public static function check(string $action, int $maxAttempts = 5, int $decaySeconds = 60): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $now = time();
        $rateKey = "rate_limit_{$action}";

        if (!isset($_SESSION[$rateKey])) {
            $_SESSION[$rateKey] = [
                'attempts' => 1,
                'reset_time' => $now + $decaySeconds
            ];
            return true;
        }

        $limitData = $_SESSION[$rateKey];

        // If the restriction window has passed, reset the session window counter
        if ($now > $limitData['reset_time']) {
            $_SESSION[$rateKey] = [
                'attempts' => 1,
                'reset_time' => $now + $decaySeconds
            ];
            return true;
        }

        // Increment attempt tracking
        $_SESSION[$rateKey]['attempts']++;

        if ($_SESSION[$rateKey]['attempts'] > $maxAttempts) {
            return false;
        }

        return true;
    }

    /**
     * Get the remaining wait time in seconds before the limit resets
     */
    public static function getRemainingTime(string $action): int {
        $rateKey = "rate_limit_{$action}";
        if (!isset($_SESSION[$rateKey])) {
            return 0;
        }
        $timeLeft = $_SESSION[$rateKey]['reset_time'] - time();
        return $timeLeft > 0 ? $timeLeft : 0;
    }

    /**
     * Manual reset function to call after a successful login or action
     */
    public static function clear(string $action): void {
        $rateKey = "rate_limit_{$action}";
        if (isset($_SESSION[$rateKey])) {
            unset($_SESSION[$rateKey]);
        }
    }
}
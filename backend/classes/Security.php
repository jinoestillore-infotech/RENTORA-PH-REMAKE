<?php
/**
 * File Location: backend/classes/Security.php
 * File Name: Security.php
 * Description: Core helper functions handling data sanitization, secure output rendering, and basic cryptography.
 */

namespace App\Classes;

class Security {
    /**
     * Prevent XSS attacks by sanitizing and escaping strings before displaying them in HTML view parameters.
     */
    public static function escape(mixed $data): string {
        if ($data === null) {
            return '';
        }
        return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Deep sanitization helper for input arrays (e.g., sanitizing POST values)
     */
    public static function sanitizeInput(array $input): array {
        $sanitized = [];
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = self::sanitizeInput($value);
            } else {
                $sanitized[$key] = trim((string)$value);
            }
        }
        return $sanitized;
    }

    /**
     * Cryptographically secure password hashing wrapper
     */
    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify a plaintext password matching standard crypt hashes
     */
    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}
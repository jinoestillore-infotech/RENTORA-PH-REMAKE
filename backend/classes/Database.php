<?php
/**
 * File Location: backend/classes/Database.php
 * File Name: Database.php
 * Description: Secure PDO Database wrapper using prepared statements and .env environment parameters.
 */

namespace App\Classes;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    /**
     * Get the secure PDO database connection instance (Singleton Pattern)
     * @return PDO
     */
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            // Set default configurations
            $host = 'localhost';
            $db   = 'rentora_ph';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            // Locate and parse the .env file at the root directory
            $envPath = __DIR__ . '/../../.env';

            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    
                    // Skip comments or empty lines
                    if ($line === '' || strpos($line, '#') === 0) {
                        continue;
                    }
                    
                    // Extract key-value pairs securely
                    if (strpos($line, '=') !== false) {
                        list($name, $value) = explode('=', $line, 2);
                        $name = trim($name);
                        $value = trim($value);
                        
                        // Strip inline comments if they exist
                        if (strpos($value, '#') !== false) {
                            list($value, ) = explode('#', $value, 2);
                            $value = trim($value);
                        }
                        
                        // Strip surrounding quotes
                        $value = trim($value, '"\'');
                        
                        $_ENV[$name] = $value;
                        putenv("$name=$value");
                    }
                }
            }

            // Retrieve configuration values from environment variables with fallback parameters
            $host = getenv('DB_HOST') ?: $host;
            $db   = getenv('DB_NAME') ?: $db;
            $user = getenv('DB_USER') ?: $user;
            $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : $pass;
            $charset = getenv('DB_CHARSET') ?: $charset;

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false, // Enforce native prepared statements
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Production-safe error logging: Never expose sensitive parameters in trace outputs
                error_log("Database connection error: " . $e->getMessage());
                die("A secure database connection error occurred. Please try again later.");
            }
        }

        return self::$instance;
    }
}
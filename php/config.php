<?php
/**
 * Database Configuration and Global Constants
 * Street Dog Fundraising and Support Management System
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'street_dog_db');

// Site Configuration
define('SITE_NAME', 'Street Dog Fundraising');
define('SITE_URL', 'http://localhost/project%204th%20sem');
define('UPLOAD_PATH', dirname(__DIR__) . '/uploads/');

// Create database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// CSRF Token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

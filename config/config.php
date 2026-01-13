<?php
/**
 * Configuration File
 * 
 * Handles environment detection (Local vs Production) and sets:
 * 1. Database Credentials
 * 2. Base URL (Path)
 */

/*
 * Detect Environment
 * 
 * If the server name is 'localhost' or '127.0.0.1', we are local.
 * Otherwise, we assume production (StackCP / cPanel).
 */
$is_local = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1');

if ($is_local) {
    // === LOCAL DEVELOPMENT SETTINGS ===
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3307'); // XAMPP Default Port (Updated to yours)
    define('DB_NAME', 'ecom_cms');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    // Base URL for links (folder name on your laptop)
    define('BASE_URL', '/Ecom-CMS/');

} else {
    // === PRODUCTION SETTINGS (JERZY.LK) ===
    define('DB_HOST', 'sdb-85.hosting.stackcp.net');
    define('DB_PORT', '3306'); // Standard MySQL Port for Hosting
    define('DB_NAME', 'ecom-cms-35303938abe5');
    define('DB_USER', 'ecom-cms-35303938abe5');
    define('DB_PASS', 'gms19ye3uz');

    // Base URL for links (deployment folder on server)
    define('BASE_URL', '/test/');
}

// Global helper for Base Path (Root Directory)
define('ROOT_PATH', dirname(__DIR__) . '/');
?>
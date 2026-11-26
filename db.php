<?php
// ============================================================
// DATABASE CONFIGURATION
// ============================================================
$db_host = 'localhost';
$db_user = 'root';           
$db_pass = '';               
$db_name = 'kariez_tracking'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ============================================================
// ADMIN LOGIN CREDENTIALS
// ============================================================
define('ADMIN_EMAIL', 'admin@kariez.com');
define('ADMIN_PASSWORD', 'kariez2026'); // Change this!
?>
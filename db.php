<?php
// ============================================================
// DATABASE CONFIGURATION
// ============================================================
$db_host = 'localhost';
$db_user = 'root';           
$db_pass = 'root';               
$db_name = 'thunderbolt_db'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ============================================================
// ADMIN LOGIN CREDENTIALS
// ============================================================
define('ADMIN_EMAIL', 'admin@kariez.com');
define('ADMIN_PASSWORD', '123456'); // Change this!
?>
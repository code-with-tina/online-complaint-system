<?php
// --------------------------
// DEBUG: Check MySQL port reachability
// --------------------------
$test = @fsockopen('127.0.0.1', 3306, $errno, $errstr, 5);
if (!$test) {
    die("Cannot reach MySQL on 127.0.0.1:3306 — check MySQL service and firewall. Error $errno: $errstr");
} else {
    // Port reachable, continue
    fclose($test);
}

// --------------------------
// Enable PHP error reporting
// --------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --------------------------
// MySQL connection
// --------------------------
$servername = "localhost"; // use 127.0.0.1 instead of localhost
$username = "root";
$password = "";  // empty root password
$dbname = "complaint_system";
$port = 3306;    // default MySQL port

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>
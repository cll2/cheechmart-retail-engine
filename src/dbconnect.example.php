<?php
// ---------------------------
// Database configuration
// ---------------------------

// Hostname or IP of the PostgreSQL server
// Use 127.0.0.1 for the same machine (loopback)
$host = "127.0.0.1";

// Name of the database to connect to
$dbname = "retail_deals";   // Replace with your own DB name

// PostgreSQL username
$user = "YOUR_DB_USER";      // Replace with your own user

// PostgreSQL password
$password = "YOUR_DB_PASSWORD"; // Replace with your own password

// ---------------------------
// Connect to PostgreSQL
// ---------------------------
// pg_connect returns a connection resource on success
// or FALSE on failure
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Check connection
if (!$conn) {
    die("Database connection failed."); // Safe message for example
}
?>

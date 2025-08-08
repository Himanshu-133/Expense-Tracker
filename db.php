<?php
// db.php - handles the MySQL connection

$host = "127.0.0.1";           // Your DB host
$user = "root";                // Your DB user
$pass = "Himanshu@1310";       // Your DB password
$db   = "expense_tracker";      // Your DB name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // Output as JSON and stop script if connection fails
    die(json_encode(['status'=>'error', 'message'=>'Connection failed: ' . $conn->connect_error]));
}
?>

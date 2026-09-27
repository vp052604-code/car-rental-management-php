<?php
$host = "localhost";
$user = "root"; // Default for XAMPP/WAMP
$pass = "";     // Default is usually blank locally
$dbname = "car_rental";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
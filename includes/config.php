<?php
$host = "sql206.infinityfree.com";
$username = "if0_42706998";
$password = "v428xsFc9e7twCJ";
$database = "if0_42706998_blog_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
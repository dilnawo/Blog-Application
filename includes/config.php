<?php

$envFile = __DIR__ . '/../.env';

if (!file_exists($envFile)) {
    die("Configuration file not found.");
}

$env = parse_ini_file($envFile);

if ($env === false) {
    die("Unable to read configuration file.");
}

$host = $env['DB_HOST'] ?? '';
$username = $env['DB_USERNAME'] ?? '';
$password = $env['DB_PASSWORD'] ?? '';
$database = $env['DB_DATABASE'] ?? '';

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
?>
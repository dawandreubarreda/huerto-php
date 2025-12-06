<?php
$envFile = __DIR__ . '/../.env';
$env = [];

if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
}

$host = $env['DB_HOST'] ?? 'localhost';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';
$name = $env['DB_NAME'] ?? 'huerto_db';

$conn = new mysqli($host, $user, $pass, $name);
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die("Error: no se pudo conectar al servicio.");
}
?>
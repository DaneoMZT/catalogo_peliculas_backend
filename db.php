<?php
$host = 'switchyard.proxy.rlwy.net';
$port = 12014;
$user = 'root';
$password = 'TaqXGlSrbEExYMYKCrhcvSxSIrMuMbFT';
$database = 'railway';

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>


<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "catalogo_peliculas";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => $conn->connect_error]));
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Falta el parámetro id"]);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM movies WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc();
    echo json_encode($movie);
} else {
    echo json_encode(["error" => "Película no encontrada"]);
}

$conn->close();
?>

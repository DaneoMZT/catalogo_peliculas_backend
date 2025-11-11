<?php
require 'db.php';

header('Content-Type: application/json');

$sql = "SELECT id, title, description, year FROM movies";
$result = $conn->query($sql);

$movies = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}

echo json_encode($movies);
$conn->close();
?>


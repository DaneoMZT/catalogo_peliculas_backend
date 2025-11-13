<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: movies.php");
exit();
?>


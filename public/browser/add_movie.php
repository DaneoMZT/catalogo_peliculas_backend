<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $director = $_POST['director'] ?? '';
    $year = $_POST['year'] ?? 0;
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';

    $stmt = $conn->prepare("INSERT INTO movies (title, director, year, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $director, $year, $description, $image);
    $stmt->execute();
    $stmt->close();

    header("Location: movies.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Película</title>
<style>
body { background:#111; color:white; font-family:Arial; text-align:center; }
form { margin:50px auto; background:#222; padding:20px; width:400px; border-radius:8px; }
input, textarea { width:90%; padding:8px; margin:10px; border-radius:5px; border:none; }
button { padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>
<h1>➕ Agregar Película</h1>
<form method="POST">
<input type="text" name="title" placeholder="Título" required><br>
<input type="text" name="director" placeholder="Director" required><br>
<input type="number" name="year" placeholder="Año"><br>
<textarea name="description" placeholder="Descripción"></textarea><br>
<input type="text" name="image" placeholder="URL Imagen"><br>
<button type="submit">Agregar</button>
</form>
<a href="movies.php" style="color:#00f;">⬅ Volver al catálogo</a>
</body>
</html>

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("INSERT INTO movies (title, description, year, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $description, $year, $image);
    $stmt->execute();

    header("Location: movies.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Película 🎬</title>
  <style>
    body {
      font-family: Arial;
      background: #111;
      color: white;
      text-align: center;
    }
    form {
      margin: 50px auto;
      background: #222;
      padding: 20px;
      width: 400px;
      border-radius: 8px;
    }
    input, textarea {
      width: 90%;
      padding: 8px;
      margin: 10px;
      border-radius: 5px;
      border: none;
    }
    button {
      padding: 10px 20px;
      background: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <h1>Agregar Nueva Película</h1>
  <form method="POST">
    <input type="text" name="title" placeholder="Título" required><br>
    <textarea name="description" placeholder="Descripción"></textarea><br>
    <input type="number" name="year" placeholder="Año"><br>
    <input type="text" name="image" placeholder="URL de Imagen (opcional)"><br>
    <button type="submit">Guardar</button>
  </form>
</body>
</html>


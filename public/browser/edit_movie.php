<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE movies SET title=?, description=?, year=?, image=? WHERE id=?");
    $stmt->bind_param("ssisi", $title, $description, $year, $image, $id);
    $stmt->execute();

    header("Location: movies.php");
    exit();
}

$result = $conn->query("SELECT * FROM movies WHERE id=$id");
$movie = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Película</title>
  <style>
    body { background:#111; color:white; font-family:Arial; text-align:center; }
    form { margin:50px auto; background:#222; padding:20px; width:400px; border-radius:8px; }
    input, textarea { width:90%; padding:8px; margin:10px; border-radius:5px; border:none; }
    button { padding:10px 20px; background:#007BFF; color:white; border:none; border-radius:5px; }
  </style>
</head>
<body>
  <h1>Editar Película</h1>
  <form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br>
    <textarea name="description"><?= htmlspecialchars($movie['description']) ?></textarea><br>
    <input type="number" name="year" value="<?= htmlspecialchars($movie['year']) ?>"><br>
    <input type="text" name="image" value="<?= htmlspecialchars($movie['image']) ?>"><br>
    <button type="submit">Actualizar</button>
  </form>
</body>
</html>


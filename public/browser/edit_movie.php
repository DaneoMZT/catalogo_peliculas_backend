<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("UPDATE movies SET title=?, description=?, year=? WHERE id=?");
    $stmt->bind_param("ssii", $title, $description, $year, $id);
    $stmt->execute();

    header("Location: index.php"); exit;
}

// Obtener datos actuales
$result = $conn->query("SELECT * FROM movies WHERE id=$id");
$movie = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Película</title>
<style>
body { font-family: Arial, sans-serif; background: #111; color: #fff; text-align: center; padding: 20px;}
form input { padding: 8px; margin: 5px; width: 200px;}
form button { padding: 8px 16px; margin-top: 5px;}
</style>
</head>
<body>

<h1>Editar Película</h1>
<form method="POST" action="">
    <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
    <input type="text" name="description" value="<?= htmlspecialchars($movie['description']) ?>" required>
    <input type="number" name="year" value="<?= htmlspecialchars($movie['year']) ?>" required>
    <button type="submit">Actualizar</button>
</form>

<p><a href="index.php">🔙 Volver al catálogo</a></p>

</body>
</html>


<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID no válido");

$result = $conn->query("SELECT * FROM movies WHERE id=$id");
$movie = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $director = $_POST['director'] ?? '';
    $year = $_POST['year'] ?? 0;
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';

    $stmt = $conn->prepare("UPDATE movies SET title=?, director=?, year=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssissi", $title, $director, $year, $description, $image, $id);
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
<title>Editar Película</title>
<style>
body { background:#111; color:white; font-family:Arial; text-align:center; }
form { margin:50px auto; background:#222; padding:20px; width:400px; border-radius:8px; }
input, textarea { width:90%; padding:8px; margin:10px; border-radius:5px; border:none; }
button { padding:10px 20px; background:#ffc107; color:#000; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>
<h1>✏️ Editar Película</h1>
<form method="POST">
<input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br>
<input type="text" name="director" value="<?= htmlspecialchars($movie['director']) ?>" required><br>
<input type="number" name="year" value="<?= htmlspecialchars($movie['year']) ?>"><br>
<textarea name="description"><?= htmlspecialchars($movie['description']) ?></textarea><br>
<input type="text" name="image" value="<?= htmlspecialchars($movie['image']) ?>"><br>
<button type="submit">Actualizar</button>
</form>
<a href="movies.php" style="color:#00f;">⬅ Volver al catálogo</a>
</body>
</html>

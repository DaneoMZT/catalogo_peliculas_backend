<?php
require 'db.php';

// ---------------------------------------------
// Agregar película si se envió formulario
// ---------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("INSERT INTO movies (title, description, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $year);
    $stmt->execute();
}

// ---------------------------------------------
// Obtener todas las películas
// ---------------------------------------------
$sql = "SELECT id, title, description, year FROM movies ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de Películas 🎬</title>
<style>
body { font-family: Arial, sans-serif; background: #111; color: #fff; text-align: center; padding: 20px;}
table { width: 80%; margin: 20px auto; border-collapse: collapse;}
th, td { padding: 12px; border: 1px solid #555;}
th { background-color: #333;}
tr:nth-child(even) { background-color: #222;}
form input { padding: 8px; margin: 5px; width: 200px;}
form button { padding: 8px 16px; margin-top: 5px;}
a { color: #0d6efd; text-decoration: none; margin: 0 5px;}
a:hover { text-decoration: underline;}
</style>
</head>
<body>

<h1>🎥 Catálogo de Películas</h1>

<h3>Agregar Nueva Película</h3>
<form method="POST" action="">
    <input type="text" name="title" placeholder="Título" required>
    <input type="text" name="description" placeholder="Descripción" required>
    <input type="number" name="year" placeholder="Año" required>
    <button type="submit" name="add_movie">Agregar</button>
</form>

<?php if ($result && $result->num_rows > 0): ?>
<table>
<tr>
<th>ID</th>
<th>Título</th>
<th>Descripción</th>
<th>Año</th>
<th>Acciones</th>
</tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['id']) ?></td>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['description']) ?></td>
<td><?= htmlspecialchars($row['year']) ?></td>
<td>
<a href="edit_movie.php?id=<?= $row['id'] ?>">✏️ Editar</a>
<a href="delete_movie.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar película?')">🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No hay películas registradas.</p>
<?php endif; ?>

</body>
</html>
<?php $conn->close(); ?>

<?php
require 'db.php';

// Directorio donde se guardan las imágenes
$uploadDir = 'assets/';

// Obtener el ID de la película
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no válido");
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $director = $_POST['director'] ?? '';
    $year = $_POST['year'] ?? 0;
    $description = $_POST['description'] ?? '';
    $imageName = $_POST['current_image'] ?? '';

    // Subir nueva imagen si se selecciona
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $imageName = time() . '_' . $originalName; // Evitar nombres duplicados
        move_uploaded_file($tmpName, $uploadDir . $imageName);
    }

    // Actualizar la base de datos
    $stmt = $conn->prepare("UPDATE movies SET title=?, director=?, year=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssissi", $title, $director, $year, $description, $imageName, $id);
    $stmt->execute();
    $stmt->close();

    // Redirigir a movies.php
    header("Location: movies.php");
    exit();
}

// Obtener los datos actuales de la película
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
        button { padding:10px 20px; background:#ffc107; color:#000; border:none; border-radius:5px; }
        button:hover { background:#e0a800; }
        img { max-width:150px; border-radius:6px; display:block; margin:10px auto; }
    </style>
</head>
<body>
    <h1>✏️ Editar Película</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br>
        <input type="text" name="director" value="<?= htmlspecialchars($movie['director']) ?>" required><br>
        <input type="number" name="year" value="<?= htmlspecialchars($movie['year']) ?>"><br>
        <textarea name="description"><?= htmlspecialchars($movie['description']) ?></textarea><br>

        <?php if(!empty($movie['image'])): ?>
            <p>Imagen actual:</p>
            <img src="assets/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
        <?php endif; ?>

        <input type="hidden" name="current_image" value="<?= htmlspecialchars($movie['image']) ?>">
        <input type="file" name="image" accept="image/*"><br>
        <button type="submit">Actualizar Película</button>
    </form>
    <a href="movies.php" class="btn" style="color:#fff; text-decoration:none; display:inline-block; margin-top:10px;">⬅ Volver al catálogo</a>
</body>
</html>

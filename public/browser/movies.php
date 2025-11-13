<?php
require 'db.php';

// 🔹 AGREGAR PELÍCULA
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $year = $_POST['year'] ?? 0;
    $image = $_POST['image'] ?? '';

    $stmt = $conn->prepare("INSERT INTO movies (title, description, year, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $description, $year, $image);
    $stmt->execute();
    $stmt->close();
}

// 🔹 EDITAR PELÍCULA
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE movies SET title=?, description=?, year=?, image=? WHERE id=?");
    $stmt->bind_param("ssisi", $title, $description, $year, $image, $id);
    $stmt->execute();
    $stmt->close();
}

// 🔹 BORRAR PELÍCULA
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// 🔹 CONSULTAR TODAS LAS PELÍCULAS
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de Películas 🎬</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #111 url('https://wallpapercave.com/wp/wp6616084.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    text-align: center;
    padding: 20px;
}
h1 { margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }
.btn { display: inline-block; padding: 8px 16px; border-radius: 5px; text-decoration:none; color:white; margin:4px; transition:0.3s; }
.btn-add { background:#28a745; } .btn-add:hover{background:#218838;}
.btn-edit { background:#ffc107; color:#000; } .btn-edit:hover{background:#e0a800;}
.btn-delete { background:#dc3545; } .btn-delete:hover{background:#c82333;}
table { width:90%; margin:20px auto; border-collapse: collapse; background: rgba(0,0,0,0.75); border-radius:10px; overflow:hidden; box-shadow:0px 0px 10px rgba(0,0,0,0.5);}
th, td { padding:12px; border-bottom:1px solid #444; }
th { background:#222; text-transform: uppercase; letter-spacing:1px;}
tr:nth-child(even){background:#1a1a1a;}
tr:hover{background:#333;transition:0.3s;}
img { border-radius:6px; max-width:100px; height:auto;}
form { margin:20px auto; background:#222; padding:20px; width:400px; border-radius:8px;}
input, textarea { width:90%; padding:8px; margin:10px; border-radius:5px; border:none;}
button { padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;}
</style>
</head>
<body>
<h1>🎥 Catálogo de Películas</h1>

<!-- FORMULARIO AGREGAR -->
<form method="POST">
<input type="hidden" name="action" value="add">
<h3>Agregar Película</h3>
<input type="text" name="title" placeholder="Título" required>
<textarea name="description" placeholder="Descripción"></textarea>
<input type="number" name="year" placeholder="Año">
<input type="text" name="image" placeholder="URL Imagen">
<button type="submit">Agregar</button>
</form>

<!-- TABLA DE PELÍCULAS -->
<table>
<thead>
<tr>
<?php
$fields = $result->fetch_fields();
foreach ($fields as $field) { echo "<th>" . htmlspecialchars($field->name) . "</th>"; }
?>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
$result->data_seek(0);
while($row = $result->fetch_assoc()):
?>
<tr>
<?php foreach($row as $key=>$value): ?>
<td>
<?php if($key==='image' && !empty($value)): ?>
<img src="<?= htmlspecialchars($value) ?>" alt="Imagen">
<?php else: ?>
<?= htmlspecialchars($value) ?>
<?php endif; ?>
</td>
<?php endforeach; ?>
<td>
<!-- FORMULARIO EDITAR -->
<form method="POST" style="display:inline-block;">
<input type="hidden" name="action" value="edit">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
<input type="text" name="description" value="<?= htmlspecialchars($row['description']) ?>">
<input type="number" name="year" value="<?= htmlspecialchars($row['year']) ?>">
<input type="text" name="image" value="<?= htmlspecialchars($row['image']) ?>">
<button type="submit" class="btn btn-edit">✏️ Editar</button>
</form>

<a href="?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Seguro que quieres eliminar esta película?');">🗑️ Borrar</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>

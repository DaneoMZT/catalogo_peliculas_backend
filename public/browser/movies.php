<?php
require 'db.php';

// 🔹 BORRAR PELÍCULA si se recibe GET
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: movies.php");
    exit();
}

// 🔹 CONSULTAR TODAS LAS PELÍCULAS
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Catálogo de Películas 🎬</title>
<style>
body {
    font-family: Arial;
    background: #111 url('https://wallpapercave.com/wp/wp6616084.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    text-align: center;
    padding: 20px;
}
h1 { text-shadow: 2px 2px 4px #000; }
.btn { display:inline-block; padding:10px 20px; border-radius:5px; text-decoration:none; margin:4px; color:white; transition:0.3s; }
.btn-add { background:#28a745; } .btn-add:hover{background:#218838;}
.btn-edit { background:#ffc107; color:#000; } .btn-edit:hover{background:#e0a800;}
.btn-delete { background:#dc3545; } .btn-delete:hover{background:#c82333;}
table { width:90%; margin:20px auto; border-collapse: collapse; background: rgba(0,0,0,0.75); border-radius:10px; overflow:hidden; box-shadow:0px 0px 10px rgba(0,0,0,0.5);}
th, td { padding:12px; border-bottom:1px solid #444; }
th { background:#222; text-transform: uppercase; letter-spacing:1px;}
tr:nth-child(even){background:#1a1a1a;}
tr:hover{background:#333;}
img { border-radius:6px; max-width:100px; height:auto;}
</style>
</head>
<body>
<h1>🎥 Catálogo de Películas</h1>
<a href="add_movie.php" class="btn btn-add">➕ Agregar Película</a>

<?php if($result && $result->num_rows > 0): ?>
<table>
<thead>
<tr>
<th>ID</th>
<th>Título</th>
<th>Director</th>
<th>Año</th>
<th>Descripción</th>
<th>Imagen</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
while($row = $result->fetch_assoc()):
?>
<tr>
<td><?= htmlspecialchars($row['id']) ?></td>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['director']) ?></td>
<td><?= htmlspecialchars($row['year']) ?></td>
<td><?= htmlspecialchars($row['description']) ?></td>
<td>
<?php if(!empty($row['image'])): ?>
<img src="<?= htmlspecialchars($row['image']) ?>" alt="Imagen">
<?php endif; ?>
</td>
<td>
<a href="edit_movie.php?id=<?= $row['id'] ?>" class="btn btn-edit">✏️ Editar</a>
<a href="?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Seguro que quieres eliminar esta película?');">🗑️ Borrar</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php else: ?>
<p>No hay películas registradas.</p>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>

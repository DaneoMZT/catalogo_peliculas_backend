<?php
// ---------------------------------------------
// 🔹 CONFIGURACIÓN DE CONEXIÓN A RAILWAY MYSQL
// ---------------------------------------------
$host = 'switchyard.proxy.rlwy.net';
$port = 12014;
$user = 'root';
$password = 'TaqXGlSrbEExYMYKCrhcvSxSIrMuMbFT';
$database = 'railway';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// ---------------------------------------------
// 🔹 CONSULTAR LAS PELÍCULAS
// ---------------------------------------------
$sql = "SELECT id, title, description, year FROM movies";
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
      background: #111;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    table {
      width: 80%;
      margin: 20px auto;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      border: 1px solid #555;
    }
    th {
      background-color: #333;
    }
    tr:nth-child(even) {
      background-color: #222;
    }
  </style>
</head>
<body>

  <h1>🎥 Catálogo de Películas</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Año</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['description']) ?></td>
          <td><?= htmlspecialchars($row['year']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>No hay películas registradas.</p>
  <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>

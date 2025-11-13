<?php
// 🔹 Conexión a la base de datos (usa variables de entorno en Railway)
require 'db.php';

// ---------------------------------------------
// 🔹 CONSULTAR TODAS LAS COLUMNAS DE LA TABLA movies
// ---------------------------------------------
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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #fff;
      text-align: center;
      padding: 20px;
      background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
                  url('https://images.unsplash.com/photo-1517602302552-471fe67acf66?auto=format&fit=crop&w=1950&q=80')
                  no-repeat center center fixed;
      background-size: cover;
    }
    h1 {
      margin-top: 20px;
      font-size: 2.5em;
      text-shadow: 2px 2px 8px #000;
    }
    table {
      width: 90%;
      margin: 40px auto;
      border-collapse: collapse;
      background: rgba(30, 30, 30, 0.9);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #444;
    }
    th {
      background-color: #333;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    tr:nth-child(even) {
      background-color: #222;
    }
    tr:hover {
      background-color: #333;
      transition: 0.3s;
    }
    img {
      border-radius: 6px;
      max-width: 100px;
      height: auto;
      box-shadow: 0 0 8px rgba(0,0,0,0.6);
    }
    footer {
      margin-top: 50px;
      font-size: 0.9em;
      color: #ccc;
    }
  </style>
</head>
<body>

  <h1>🎥 Catálogo de Películas</h1>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <?php
          // 🔹 Encabezados dinámicos según las columnas de la base de datos
          $fields = $result->fetch_fields();
          foreach ($fields as $field) {
              echo "<th>" . htmlspecialchars($field->name) . "</th>";
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // 🔹 Reiniciar el puntero y recorrer todos los registros
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <?php foreach ($row as $key => $value): ?>
              <td>
                <?php if ($key === 'image' && !empty($value)): ?>
                  <img src="<?= htmlspecialchars($value) ?>" alt="Imagen">
                <?php else: ?>
                  <?= htmlspecialchars($value) ?>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No hay películas registradas.</p>
  <?php endif; ?>

  <footer>
    © 2025 Catálogo de Películas | Desarrollado por <strong>Daniel Ruiz Beltrán</strong>
  </footer>

</body>
</html>

<?php
$conn->close();
?>

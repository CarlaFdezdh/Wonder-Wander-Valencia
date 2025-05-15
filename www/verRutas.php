<?php
$miquery = $_POST["queryN"] ?? '';

// Conexión a la base de datos
$bd = "rutas.db";
$conn = new SQLite3($bd, SQLITE3_OPEN_READONLY);

// Usamos consulta preparada para evitar inyecciones
$stmt = $conn->prepare("SELECT * FROM ruta WHERE nombre LIKE :nombre");
$stmt->bindValue(':nombre', $miquery . '%', SQLITE3_TEXT);
$result = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Rutas</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styleindex.css">
  <link rel="stylesheet" href="styles/styleaddRuta.css">
</head>
<body>
  <h1>Wonder Wander Valencia</h1>

  <form action="verRutas.php" method="post" id="queryform">
    <input type="text" id="queryN" name="queryN" placeholder="Buscar rutas..." value="<?= htmlspecialchars($miquery) ?>">
    <input type="submit" value="Buscar">
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Distancia (KM)</th>
        <th>Caminando</th>
        <th>Bici</th>
        <th>Con mascota</th>
        <th>Con silla de ruedas</th>
        <th>Imagen</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
          <?php foreach ($row as $key => $item): ?>
            <?php if ($key === 'imagen'): ?>
              <td><img src="imgSubidas/<?= htmlspecialchars($item) ?>" alt="Imagen de la ruta" height="200" width="200"></td>
            <?php else: ?>
              <td><?= htmlspecialchars($item) ?></td>
            <?php endif; ?>
          <?php endforeach; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>

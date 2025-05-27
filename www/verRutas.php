<?php
$miquery = $_POST["queryN"] ?? '';

// Conexión a la base de datos
$bd = "rutas.db";
$conn = new SQLite3($bd, SQLITE3_OPEN_READONLY);

// Usamos consulta preparada para evitar inyecciones
$stmt = $conn->prepare("SELECT * FROM ruta WHERE nombre LIKE :nombre");
$stmt->bindValue(':nombre', '%' . $miquery . '%', SQLITE3_TEXT);
$result = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Rutas</title>
  <link rel="stylesheet" href="styles/styleindex.css">
  <link rel="icon" href="media/imgs/mountains-mountain-svgrepo-com.svg" type="image/svg+xml">

</head>
<body>
    <header>
        <img src="media/imgs/mountains-mountain-svgrepo-com.svg" alt="" width="72" height="72">
        <h1>Wonder Wander Valencia</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.html">HOME</a></li>
            <li><a href="#">BUSCA TU RUTA</a></li>
            <li><a href="addRuta.html">INGRESA TU RUTA</a></li>
            <li><a href="conocenos.html">CONOCENOS</a></li>
        </ul>
    </nav>

  <form action="verRutas.php" method="post" id="queryform">
    <input type="text" id="queryN" name="queryN" placeholder="Buscar rutas..." value="<?= htmlspecialchars($miquery) ?>">
    <input type="submit" value="Buscar">
  </form>
  <main id="vr">
  <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
    <div class="card">
      <h2><?= htmlspecialchars($row['nombre']) ?></h2>
      <div class="card-body">
        <div>
        <p><strong>Distancia:</strong> <span class="attrib"> <?= htmlspecialchars($row['distancia']) ?> km</span></p>
        <p><strong>Recomendado:</strong></p>
          <?php if ($row['caminando']==1):
            echo "<span class='attrib'>Caminando</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['bici']==1): 
            echo "<span class='attrib'>En bici</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['mascota']==1):
            echo "<span class='attrib'>Con mascota</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['silla']==1):
            echo "<br><span class='attrib'>En silla de ruedas</span>"
            ?>
          <?php endif; ?>
          </div>
            <?php foreach ($row as $key => $item): ?>
            <?php if ($key === 'imagen'): ?>
            <img src="imgSubidas/<?= htmlspecialchars($item) ?>" alt="Imagen de la ruta" height="220" width="330">
            <?php endif; ?>
            <?php if ($key === 'mapa'): ?>
            <!-- esto es un placeholder-->
            <?php echo "<iframe frameBorder='0' scrolling='no' src='".$row['mapa']."' width='500' height='400'></iframe>" ?>
            <?php endif; ?>
          <?php endforeach; ?>
      </div>
    </div>
      <?php endwhile; ?>
  </main>
  <!--<table class="table table-bordered">
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
    <?php/* while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
          <?php foreach ($row as $key => $item): ?>
            <?php if ($key === 'imagen'): ?>
              <td><img src="imgSubidas/<?= htmlspecialchars($item) ?>" alt="Imagen de la ruta" height="200" width="200"></td>
            <?php else: ?>
              <td><?= htmlspecialchars($item) ?></td>
            <?php endif; ?>
          <?php endforeach; ?>
        </tr>
      <?php endwhile;*/ ?>-->
    </tbody>
  </table>
</body>
</html>

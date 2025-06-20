<?php
$miquery = $_POST["queryN"] ?? '';
if ($_POST["maxkm"]==''){
  $miquery2 = 256;
}else{
  $miquery2 = $_POST["maxkm"] ?? 256;
}
if ($_POST["minkm"]== ''){
  $miquery3 = 0;
}else{
  $miquery3 = $_POST["minkm"] ?? 0;
}

$bd = "rutas.db";
$conn = new SQLite3($bd, SQLITE3_OPEN_READONLY);

// Usamos consulta preparada para evitar inyecciones

  $stmt = $conn->prepare("SELECT * FROM ruta 
                        WHERE nombre LIKE :nombre 
                        AND distancia <= :distmax 
                        AND distancia >= :distmin");
  $stmt->bindValue(':nombre', '%' . $miquery . '%', SQLITE3_TEXT);
  $stmt->bindValue(':distmax', $miquery2, SQLITE3_INTEGER);
  $stmt->bindValue(':distmin', $miquery3, SQLITE3_INTEGER);

$result = $stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search trails</title>
  <link rel="stylesheet" href="styles/styleindex.css">
  <link rel="icon" href="media/imgs/logoWWV.png" type="image/svg+xml">
</head>
<body>
    <header>
        <img src="media/imgs/logoWWV.png" alt="" width="72" height="72">
        <h1>Wonder Wander Valencia</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">HOME</a></li>
            <li><a href="#">FIND YOUR TRAIL</a></li>
            <li><a href="addRuta.html">UPLOAD YOUR TRAIL</a></li>
            <li><a href="conocenos.html">CONTACT US</a></li>
        </ul>
    </nav>
  <form action="verRutas.php" method="post" id="queryform">
    <div id="distanciasf">
    <input type="text" id="queryN" name="queryN" placeholder="Search trails..." value="<?= htmlspecialchars($miquery) ?>">
    <div>
    <!--<label for="minkm" >Min (Km)</label>-->
    <input type="number" id="minkm" name="minkm" placeholder="Min km" min="0">
    </div>
    <div>
    <!--<label for="maxkm" >Max (Km)</label>-->
    <input type="number" id="maxkm" name="maxkm" placeholder="Max km" min="0">
    </div>
    </div>
    <input type="submit" value="Search">
  </form>
  <main id="vr">
  <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
    <div class="card">
      <h2><?= htmlspecialchars($row['nombre']) ?></h2>
      <div class="card-body">
        <div>
        <p><strong>Distance:</strong> <span class="attrib"> <?= htmlspecialchars($row['distancia']) ?> km</span></p>
        <p><strong>Recommended:</strong></p>
          <?php if ($row['caminando']==1):
            echo "<span class='attrib'>Walking</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['bici']==1): 
            echo "<span class='attrib'>By bike</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['mascota']==1):
            echo "<span class='attrib'>With pet</span>"
            ?>
          <?php endif; ?>
          <?php if ($row['silla']==1):
            echo "<br><span class='attrib'>In a wheelchair</span>"
            ?>
          <?php endif; ?>
          </div>
            <?php foreach ($row as $key => $item): ?>
            <?php if ($key === 'imagen'): ?>
            <img src="imgSubidas/<?= htmlspecialchars($item) ?>" alt="Pic of the trail" height="220" width="330">
            <?php endif; ?>
            <?php if ($key === 'mapa'): ?>
            <?php echo "<iframe frameBorder='0' scrolling='no' src='".$row['mapa']."' width='500' height='400'></iframe>" ?>
            <?php endif; ?>
          <?php endforeach; ?>
      </div>
    </div>
      <?php endwhile; ?>
  </main>
    </tbody>
  </table>
</body>
</html>

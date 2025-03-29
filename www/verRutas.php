<?php
//var_dump($_POST);
$miquery=$_POST["queryN"] ?? null;

$bd="rutas.db";

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styleindex.css">
    <link rel="stylesheet" href="styles/styleaddRuta.css">
  <title>Ver Rutas</title>
</head>
<body>
  <h1>Wonder Wander Valencia</h1>
  <form action="queryPage.php" method="post" id="queryform">
    <input type="text" id="queryN">
    <input type="submit" form="queryform">
  </form>
  <table>
    <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Distancia(KM)</th>
    <th>Caminando</th>
    <th>Bici</th>
    <th>Con mascota</th>
    <th>Con silla de ruedas</th>
    <th>Imagen</th>
    </tr>
  <?php
$conn=new SQLite3($bd,SQLITE3_OPEN_READONLY); // abrimos otra vez la DB
  // esta vez le pasamos el parametro "SQLITE3_OPEN_READONLY" esto hace que solo permita realizar
  // consultas, que es lo que queremos ahora mismo
  $sql="select * from ruta where nombre like '".$miquery."%'"; // este es el codigo para realizar una consulta a la tabla
  // que hemos creado
  $result=$conn->query($sql); //guardamos el resultado de la consulta en $result
  // para ejecutar el codigo utilizamos el metodo query ya que realizamos una consulta
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) { // mientras $result siga teniendo datos...
    echo "<tr>";
    $i=0;
    foreach($row as $item){ // por cada item* de $row
      $i++;
      // * aqui tenemos que entender que $row es una array con los datos de una linea de nuestra tabla
      if ($i==8) {
        echo "<td><img src='imgSubidas/$item' alt='imagen de la ruta' height='200' width='200'></td>\n";
      } elseif ($i>3) {
          switch ($item) {
            case 0:
              echo "<td>&#10060</td>\n";

                break;
            case 1:
              echo "<td>&#9989</td>\n";

                break;
        }
        } else {
          echo "<td>$item</td>\n";
        }
        
      }
      
    }
    echo "</tr>\n";
  $result->finalize(); // cerramos la variable result
  $conn->close(); // cerramos el objeto SQLite
  ?>
  <br>
  <br>
  </table>

</form>
</body>
</html>
<?php
$bd="ruta.db";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>verRutas</title>
  <link rel="stylesheet" href="styles/styleindex.css">
</head>
<body>
  <h1>Wonder Wander Valencia</h1>
  <table>
    <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Email</th>
    </tr>
  <?php
  $conn=new SQLite3($bd,SQLITE3_OPEN_READONLY); // abrimos otra vez la DB
  // esta vez le pasamos el parametro "SQLITE3_OPEN_READONLY" esto hace que solo permita realizar
  // consultas, que es lo que queremos ahora mismo
  $sql="select * from MyGuests"; // este es el codigo para realizar una consulta a la tabla
  // que hemos creado
  $result=$conn->query($sql); //guardamos el resultado de la consulta en $result
  // para ejecutar el codigo utilizamos el metodo query ya que realizamos una consulta
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) { // mientras $result siga teniendo datos...
    echo "<tr>";
    foreach($row as $item){ // por cada item* de $row
      // * aqui tenemos que entender que $row es una array con los datos de una linea de nuestra tabla
      echo "<td>$item</td>\n";
    }
    echo "</tr>\n";
  }
  $result->finalize(); // cerramos la variable result
  $conn->close(); // cerramos el objeto SQLite
  ?>
  <br>
  <br>
  </table>
  <form action="oldActionPage.php" method="post" id="form1">  <!-- action indica que hará el formulario
    cuando lo enviemos, (abrir la pagina actionPage.php), indicamos que vamos a enviar la informacion
    a la otra pagina mediate el metodo post -->
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname" required><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname" required><br>
  <label for="email">Email</label><br>
  <input type="text" id="email" name="email" required><br><br>
  <button type="submit" form="form1" value="Submit">Enviar</button> 
  <!-- ** la explicacion sigue en actionPage.php -->
</form> 
</body>
</html>
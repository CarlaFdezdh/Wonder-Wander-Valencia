<?php
//var_dump($_POST);
$miquery=$_POST["queryN"] ?? null;

$bd="miDB.db";
$conn=new SQLite3($bd); // Creamos un objeto de la clase SQLite3, al que
// le pasamos como parametro el nombre de la base de datos
$sql="CREATE TABLE MyGuests ( 
    id INTEGER PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL, -- Guardamos en la variable sql el codigo sql necesario 
    lastname VARCHAR(30) NOT NULL,  -- para crear una tabla
    email VARCHAR(50))";
//$conn->exec($sql); Este comando ejecuta lo que haya en la variable $sql
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
  VALUES ('John', 'Doe', 'john@example.com')";
//$conn->exec($sql);
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
  VALUES ('Marcos', 'Pardo', 'aaaa@example.com'),('aa', 'dsdd', 'adasd@example.com')";
//$conn->exec($sql);
$conn->close(); // cerramos la base de datos, esto hay que hacerlo siempre que terminemos de usarla
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
  <title>Document</title>
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
    <th>Apellido</th>
    <th>Email</th>
    </tr>
  <?php
$conn=new SQLite3($bd,SQLITE3_OPEN_READONLY); // abrimos otra vez la DB
  // esta vez le pasamos el parametro "SQLITE3_OPEN_READONLY" esto hace que solo permita realizar
  // consultas, que es lo que queremos ahora mismo
  $sql="select * from MyGuests where firstname like '".$miquery."%'"; // este es el codigo para realizar una consulta a la tabla
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
  <form action="actionPage.php" method="post" id="form1">  <!-- action indica que hará el formulario
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
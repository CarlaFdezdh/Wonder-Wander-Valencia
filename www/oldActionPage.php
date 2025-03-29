<?php
var_dump($_POST); // tenemos la variable post, con los datos que hemos enviado desde el formulario
$bd="miDB.db";
$conn=new SQLite3($bd);
//metemos los datos a la base de datos de la siguiente forma:
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
  VALUES ('". $_POST["fname"] . "', '".$_POST["lname"]."', '".$_POST["email"]."')";
$conn->exec($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- redireccionamos al usuario inmediatamente al index.php -->
  <meta http-equiv="refresh" content="0; url=http://localhost/oldVerRutas.php" /> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Redirect</title>
</head>
<body>
</body>
</html>
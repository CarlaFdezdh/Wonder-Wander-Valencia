<?php
$bd="rutas.db";
echo ini_get("file_uploads");
//ini_set(option: "file_uploads","On");
var_dump($_POST); // tenemos la variable post, con los datos que hemos enviado desde el formulario
var_dump($_FILES["imageUpload"]);
$dirSubidas="imgSubidas/";
$conn=new SQLite3($bd);
$miId = $conn->querySingle("SELECT max(id) FROM ruta") + 1; // Incrementamos el ID máximo


$nomImage=$miId.".png";

if(isset($_POST["caminando"])){
  $c1="true";
}else{
  $c1="false";
}
if(isset($_POST["bici"])){
  $c2="true";
}else{
  $c2="false";
}
if(isset($_POST["mascota"])){
  $c3="true";
}else{
  $c3="false";
}
if(isset($_POST["sillaRuedas"])){
  $c4="true";
}else{
  $c4="false";
}
$conn->close();

move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $dirSubidas.$nomImage);

$conn=new SQLite3($bd);
//metemos los datos a la base de datos de la siguiente forma:
$sql='INSERT INTO ruta
VALUES('.$miId.' ,'.'"'.$_POST['nom'].'"'.' ,'.$_POST['dist'].' ,'.$c1.' ,'.$c2.' ,'.$c3.' ,'.$c4.' ,'.'"'.$nomImage.'"'.','.'"'.$_POST['mapa'].'"'.')';
echo $sql;
$conn->exec($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- redireccionamos al usuario inmediatamente al index.php -->
  <meta http-equiv="refresh" content="0; url=http://localhost/addRuta.html" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Redirect</title>
</head>
<body>
</body>
</html>
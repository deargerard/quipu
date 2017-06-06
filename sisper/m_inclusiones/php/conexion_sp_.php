<?php
$host="localhost";
$user="sisweb";
$password="Ministeri0#23";
$bd="new_bdcaj";

//var_dump(function_exists('mysqli_connect'));

$cone = mysqli_connect($host,$user,$password,$bd);

//Check connection
if (mysqli_connect_errno()){
  echo "Fallo la conexión a MySQL en el servidor: " . mysqli_connect_error();
}

//para pruebas
?>
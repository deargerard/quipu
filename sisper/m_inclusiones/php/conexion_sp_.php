<?php
$host="10.6.100.22";
$user="web";
$password='Cajamarca#07';
$bd="new_bdcaj";

//var_dump(function_exists('mysqli_connect'));

$cone = mysqli_connect($host,$user,$password,$bd);

//Check connection
$conex=true;
if (!$cone){
  //echo "Fallo la conexión a MySQL en el servidor: " . mysqli_connect_error();
  $conex=false;
}
//pruebas
?>

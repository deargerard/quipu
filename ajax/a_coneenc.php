<?php
$host="192.168.16.3";
$user="web";
$password="Cajamarca#07";
$bd="encuesta";

//var_dump(function_exists('mysqli_connect'));

$con = mysqli_connect($host,$user,$password,$bd);

//Check connection
$conex=true;
if (!$con){
  //echo "Fallo la conexión a MySQL en el servidor: " . mysqli_connect_error();
  $conex=false;
}else{
	//echo "Hecho";
}
//pruebas
?>
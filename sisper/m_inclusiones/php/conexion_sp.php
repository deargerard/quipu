﻿<?php
$host="192.168.16.3";
$user="web";
$password="Cajamarca#07";
$bd="new_bdcaj";

//var_dump(function_exists('mysqli_connect'));

$cone = mysqli_connect($host,$user,$password,$bd);

//Check connection
if (mysqli_connect_errno()){
  echo "Fallo la conexión a MySQL: " . mysqli_connect_error();
}

?>

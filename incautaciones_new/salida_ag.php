<?php 
include("conect.php");
$sql=conect();
$link=conect();
$id=strtolower($_POST['id']);
$boletas=$_POST['boletas'];
$fechas=$_POST['fechas'];
$proceso=$_POST['proceso'];
$resol=strtolower($_POST['resol']);
$obs1=strtolower($_POST['obs1']);
$obs2=strtolower($_POST['obs2']);
$condicion=strtolower($_POST['condicion']);
/*registro del recibo de ingreso*/
mysqli_query($link,"update inventario set b_salida='$boletas',f_salida='$fechas',resol_salida='$resol',existente='$proceso',obs1='$obs1',obs2='$obs2',condicion='$condicion' where id=$id");
  //echo $codigo,"/",$boletai,"/",$caso,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$obs1,"/",$obs2,"/",$delito,"/",$fiscal,"/",$fiscalia,"/",$condicion;
header("Location: inventario.php");?>
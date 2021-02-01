<?php 
include("conect.php");
$sql=conect();
$id=strtolower($_POST['id']);
$boletai=$_POST['boletai'];
$fechai=$_POST['fechai'];
$ubicacion=$_POST['ubicacion'];
$caso=strtolower($_POST['caso']);
$obs1=strtolower($_POST['obs1']);
$obs2=strtolower($_POST['obs2']);
$descripcion=strtolower($_POST['descripcion']);
$marca=strtolower($_POST['marca']);
$serie=$_POST['serie'];
$estado=$_POST['estado'];
$tipo=$_POST['tipo'];
$delito=strtolower($_POST['delito']);
$fiscal=strtolower($_POST['fiscal']);
$fiscalia=strtolower($_POST['fiscalia']);
$condicion=strtolower($_POST['condicion']);
/*registro del recibo de ingreso*/
$actualizar="UPDATE inventario SET b_ingreso='$boletai', f_ingreso='$fechai', ubicacion='$ubicacion', caso='$caso', obs1='$obs1', obs2='$obs2', condicion='$condicion', descripcion='$descripcion', marca='$marca', serie='$serie', estado='$estado', elem_bien='$tipo', delito='$delito', fiscal='$fiscal', fiscalia='$fiscalia' WHERE id=$id";
mysqli_query($sql,$actualizar);
//inventario SET b_ingreso='$boletai', f_ingreso='$fechai', ubicacion='$ubicacion', caso='$caso', obs1='$obs1', obs2='$obs2', condicion='$condicion, 'descripcion='$descripcion', marca='$marca', serie='$serie', estado='$estado', elem_bien='$tipo', delito='$delito', fiscal='$fiscal', fiscalia='$fiscalia' WHERE id=$id;
  echo $id,"/",$boletai,"/",$fechai,"/",$caso,"/",$ubicacion,"/",$obs1,"/",$obs2,"/",$condicion,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$delito,"/",$fiscal,"/",$fiscalia;
header("Location: lista_casos.php");?>
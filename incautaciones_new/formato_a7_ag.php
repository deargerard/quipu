<!--<body onload='document.agregar.submit()'>-->
<?php 
include("conect.php");
$link=conect();
//$lib = mysqli_query($sql,"select max(id) as ultimo_id from inventario");
//$rs_lib = mysqli_fetch_assoc($lib);
//$codigo= $rs_lib['ultimo_id'] + 1;
$id=$_POST['id'];
$fecha=$_POST['fecha'];
$hora=$_POST['hora'];
$registro=$_POST['registro'];
$nombre=strtolower($_POST['nombre']);
$dni=strtolower($_POST['dni']);
$cargo=strtolower($_POST['cargo']);

//////////////////////////////////////////////////////////////////////////////////////////////////
mysqli_query($link,"insert into detalle_1_a7 values($id,$registro,'$fecha','$hora','$nombre','$dni','$cargo')");
  //echo $id,"/",$registro,"/",$fecha,"/",$hora,"/",$nombre,"/",$dni,"/",$cargo;
header("Location: formato_A_y_B.php?id=$id");?>
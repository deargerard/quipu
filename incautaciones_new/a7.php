<!--<body onload='document.agregar.submit()'>-->
<?php 
include("conect.php");
$link=conect();
//$lib = mysqli_query($sql,"select max(id) as ultimo_id from inventario");
//$rs_lib = mysqli_fetch_assoc($lib);
//$codigo= $rs_lib['ultimo_id'] + 1;
$id=$_GET['id'];
$caso=$_GET['caso'];
//////////////////////////////////////////////////////////////////////////////////////////////////
mysqli_query($link,"insert into formato_a7 values($id,'$caso','')");
  //echo $id,"/",$caso;
header("Location: a7-llenar.php?id=$id&caso=$caso");?>
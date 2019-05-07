<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  $r=array();
  if(isset($_POST['ida']) && !empty($_POST['ida']) && isset($_POST['solu']) && !empty($_POST['solu']) && isset($_POST['med']) && !empty($_POST['med'])){
    $ida=iseguro($cone,$_POST['ida']);
    $solu=imseguro($cone,$_POST['solu']);
    $med=iseguro($cone,$_POST['med']);
    $hoy=date('Y-m-d H:i');

    $c="UPDATE maatencion SET Solucion='$solu', Medio=$med, Estado=1, FecSolucion='$hoy' WHERE idAtencion=$ida";
    if(mysqli_query($cone,$c)){
      $r['exito']=true;
      $r['mensaje']=mensajesu("Atención resuelta.");
    }else{
      $r['exito']=false;
      $r['mensaje']=mensajeda("Error al resolver, vuelva a intentarlo.");
    }

  }else{
    $r['exito']=false;
    $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
  }

  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
